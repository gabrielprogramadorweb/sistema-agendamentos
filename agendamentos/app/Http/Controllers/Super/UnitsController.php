<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\UnitModel;
use App\Services\MessageService;
use App\Services\UnitService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUnitRequest;
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
            $units = UnitModel::query()->paginate(5)->withQueryString();
            $table = $this->unitService->getAllUnitsFormatted(5);
            $title = 'Unidades';
            return view('Back.Units.index', compact('units', 'title', 'table'));
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
            return view('Back.Units.create', compact('title', 'serviceTimes'));
        } catch (\Exception $e) {
            \Log::error("Error accessing create unit page: " . $e->getMessage());
            return redirect()->back()->withErrors('Failed to access the create unit page.');
        }
    }

    public function store(Request $request)
    {
        $validatedData = $this->unitService->validateUnit($request);
        $validatedData['active'] = $request->has('active') ? 1 : 0;

        try {
            UnitModel::create($validatedData);
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
            return view('Back.Units.edit', compact('unit', 'title', 'serviceTimes'));
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
            return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
        } catch (\Exception $e) {
            \Log::error("Error deleting unit: " . $e->getMessage());
            return redirect()->back()->withErrors('Failed to delete the unit.');
        }
    }
}
