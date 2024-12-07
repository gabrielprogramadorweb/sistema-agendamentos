<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\UnitModel;
use App\Services\MessageService;
use App\Services\UnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUnitRequest;

class UnitsController extends Controller
{
    protected $unitService;
    protected $messageService;
    protected $serviceTimes = [
        '10 minutes' => '10 minutos',
        '15 minutes' => '15 minutos',
        '30 minutes' => '30 minutos',
        '1 hour'     => '1 hora',
        '2 hours'    => '2 horas',
    ];

    public function __construct(UnitService $unitService, MessageService $messageService)
    {
        $this->unitService = $unitService;
        $this->messageService = $messageService;
    }
    public function index(Request $request)
    {
        try {
            $query = UnitModel::query();

            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where('name', 'LIKE', '%' . $search . '%');
            }
            $notifications = Notification::orderBy('created_at', 'desc')->get();

            $units = $query->paginate(5)->withQueryString();
            $table = $this->unitService->getAllUnitsFormatted($units);
            $title = 'Unidades';

            return view('Admin.Units.index', compact('notifications','units', 'title', 'table'));
        } catch (\Exception $e) {
            \Log::error("Error loading units index: " . $e->getMessage());
            return redirect()->back()->withErrors('Unable to load units.');
        }
    }

    public function create()
    {
        try {
            $title = 'Criar unidade nova';
            $serviceTimes = $this->serviceTimes;
            $notifications = Notification::orderBy('created_at', 'desc')->get();

            return view('Admin.Units.create', compact('title', 'serviceTimes' ,'notifications'));
        } catch (\Exception $e) {
            \Log::error("Error accessing create unit page: " . $e->getMessage());
            return redirect()->back()->withErrors('Failed to access the create unit page.');
        }
    }

    public function store(Request $request)
    {
        try {
            $inputData = $this->unitService->sanitizeInput($request->all());
            $validatedData = $this->unitService->validateUnit(new Request($inputData));
            $validatedData['active'] = $request->has('active') ? 1 : 0;
            if (isset($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }

            $unit = UnitModel::create($validatedData);
            $message = $this->messageService->prepareCreateMessages();
            return redirect()->route('units.index')->with($message['type'], $message['message']);
        } catch (\Exception $e) {
            $message = $this->messageService->prepareCreateMessages($e);
            return redirect()->back()->with($message['type'], $message['message']);
        }
    }

    public function edit($id)
    {
        try {
            $unit = UnitModel::findOrFail($id);
            $title = "Edit Unit";
            $serviceTimes = $this->serviceTimes;
            $notifications = Notification::orderBy('created_at', 'desc')->get();

            return view('Admin.Units.edit', compact('unit', 'title', 'serviceTimes', 'notifications'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error("Unit not found: " . $e->getMessage());
            return redirect()->route('units.index')->with('error', "Unit not found.");
        } catch (\Exception $e) {
            \Log::error("Error accessing edit unit page: " . $e->getMessage());
            return redirect()->back()->withErrors('Failed to access the edit unit page.');
        }
    }

    public function update(Request $request, $id)
    {
        $unit = UnitModel::findOrFail($id);
        $currentData = $unit->toArray();
        $inputData = $request->only(array_keys($currentData));
        $changes = array_diff_assoc($inputData, $currentData);

        if (empty($changes) && !$request->has('forceUpdate')) {
            $message = $this->messageService->prepareUpdateMessages($changes);
            return redirect()->back()->with($message['type'], $message['message']);
        }

        try {
            $validatedData = $this->unitService->validateUnit($request);
            $validatedData['active'] = $request->has('active') ? 1 : 0;
            $validatedData = $this->unitService->sanitizeInput($request->all());
            $unit->update($validatedData);
            $message = $this->messageService->prepareUpdateMessages($changes);
            return redirect()->back()->with($message['type'], $message['message']);
        } catch (\Exception $e) {
            $message = $this->messageService->prepareUpdateMessages($changes, $e);
            return redirect()->back()->with($message['type'], $message['message']);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $unit = UnitModel::findOrFail($id);
            $unit->active = !$unit->active;
            $unit->save();
            $message = $this->messageService->prepareActiveMessages($unit->active);
            return redirect()->route('units.index')->with($message['type'], $message['message']);
        } catch (\Exception $e) {
            $message = $this->messageService->prepareActiveMessages($unit->active ?? false, $e);
            return redirect()->back()->with($message['type'], $message['message']);
        }
    }

    public function destroy($id)
    {
        try {
            $unit = UnitModel::findOrFail($id);
            $unit->delete();
            $message = $this->messageService->prepareExcluirMessages();
            return redirect()->route('units.index')->with($message['type'], $message['message']);
        } catch (\Exception $e) {
            $message = $this->messageService->prepareExcluirMessages($e);
            return redirect()->back()->with($message['type'], $message['message']);
        }
    }
}
