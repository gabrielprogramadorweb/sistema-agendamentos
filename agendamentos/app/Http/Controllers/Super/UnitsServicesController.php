<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\UnitModel;
use App\Services\MessageService;
use App\Services\ServiceService;
use App\Services\UnitServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnitsServicesController extends Controller
{
    public function __construct(
        private UnitModel $unitModel,
        private MessageService $messageService,
        private ServiceService $serviceService,
        private UnitServiceService $unitServiceService
    ) {}

    public function services(int $unitId)
    {
        try {
            $unit = $this->unitModel->findOrFail($unitId);
            $services = $unit->services; // Using the custom accessor
            $existingServiceIds = $services->pluck('id')->toArray();

            $data = [
                'title' => 'Gerenciar serviços da unidade',
                'unit'  => $unit,
                'servicesOptions' => $this->unitServiceService->renderServicesOptions($existingServiceIds),
            ];

            return view('Back/Units/services', $data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Unit not found: {$unitId}");
            return redirect()->route('units.index')->with('error', 'Unidade não encontrada.');
        }
    }
}
