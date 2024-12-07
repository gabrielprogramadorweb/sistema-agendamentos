<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\ServiceModel;
use App\Services\MessageService;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;
    protected $messageService;
    protected $serviceTimes = [
        '10 minutes' => '10 minutos',
        '15 minutes' => '15 minutos',
        '30 minutes' => '30 minutos',
        '1 hour'     => '1 hora',
        '2 hours'    => '2 horas',
    ];

    public function __construct(ServiceService $serviceService, MessageService $messageService)
    {
        $this->serviceService = $serviceService;
        $this->messageService = $messageService;
    }
    public function index(Request $request)
    {
        try {
            $query = ServiceModel::query();

            if ($request->has('search')) {
                $query->where('name', 'LIKE', '%' . $request->input('search') . '%');
            }

            $notifications = Notification::orderBy('created_at', 'desc')->get();
            $services = $query->paginate(5)->withQueryString();
            $table = $this->serviceService->getAllServicesFormatted($services);
            $title = 'Serviços';

            return view('Admin.Services.index', compact('notifications','services', 'title', 'table'));
        } catch (\Exception $e) {
            \Log::error("Error loading services index: " . $e->getMessage());
            return redirect()->back()->withErrors('Unable to load services.');
        }
    }

    public function create()
    {
        try {
            $title = 'Criar serviço novo';
            $serviceTimes = $this->serviceTimes;
            $notifications = Notification::orderBy('created_at', 'desc')->get();

            return view('Admin.Services.create', compact('title', 'serviceTimes', 'notifications'));
        } catch (\Exception $e) {
            \Log::error("Error accessing create unit page: " . $e->getMessage());
            return redirect()->back()->withErrors('Failed to access the create unit page.');
        }
    }

    public function store(Request $request)
    {
        $validatedData = $this->serviceService->validateService($request);
        $validatedData['active'] = $request->has('active') ? 1 : 0;

        try {
            $validatedData = $this->serviceService->sanitizeInput($request->all());
            ServiceModel::create($validatedData);
            $message = $this->messageService->prepareCreateMessages();
            return redirect()->route('services.index')->with($message['type'], $message['message']);
        } catch (\Exception $e) {
            $message = $this->messageService->prepareCreateMessages($e);
            return redirect()->back()->with($message['type'], $message['message']);
        }
    }

    public function edit($id)
    {
        try {
            $services = ServiceModel::findOrFail($id);
            $title = "Editar Serviços";
            $serviceTimes = $this->serviceTimes;
            $notifications = Notification::orderBy('created_at', 'desc')->get();

            return view('Admin.Services.edit', compact('services', 'title', 'serviceTimes', 'notifications'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error("Unit not found: " . $e->getMessage());
            return redirect()->route('services.index')->with('error', "Services not found.");
        } catch (\Exception $e) {
            \Log::error("Error accessing edit unit page: " . $e->getMessage());
            return redirect()->back()->withErrors('Failed to access the Services unit page.');
        }
    }

    public function update(Request $request, $id)
    {
        $services = ServiceModel::findOrFail($id);
        $currentData = $services->toArray();
        $inputData = $request->only(array_keys($currentData));
        $changes = array_diff_assoc($inputData, $currentData);

        if (empty($changes) && !$request->has('forceUpdate')) {
            $message = $this->messageService->prepareUpdateMessages($changes);
            return redirect()->back()->with($message['type'], $message['message']);
        }

        try {
            $validatedData = $this->serviceService->validateService($request);
            $validatedData['active'] = $request->has('active') ? 1 : 0;
            $validatedData = $this->serviceService->sanitizeInput($request->all());
            $services->update($validatedData);
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
            $services = ServiceModel::findOrFail($id);
            $services->active = !$services->active;
            $services->save();
            $message = $this->messageService->prepareActiveMessages($services->active);
            return redirect()->route('services.index')->with($message['type'], $message['message']);
        } catch (\Exception $e) {
            $message = $this->messageService->prepareActiveMessages($services->active ?? false, $e);
            return redirect()->back()->with($message['type'], $message['message']);
        }
    }

    public function destroy($id)
    {
        try {
            $services = ServiceModel::findOrFail($id);
            $services->delete();
            $message = $this->messageService->prepareExcluirMessages();
            return redirect()->route('services.index')->with($message['type'], $message['message']);
        } catch (\Exception $e) {
            $message = $this->messageService->prepareExcluirMessages($e);
            return redirect()->back()->with($message['type'], $message['message']);
        }
    }
}
