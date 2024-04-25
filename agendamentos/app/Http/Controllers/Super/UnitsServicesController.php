<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\UnitModel;
use App\Services\MessageService;
use App\Services\ServiceService;
use App\Services\UnitServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @property $request
 */
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

    public function storeServices(Request $request, int $unitId)
    {
        try {
            $unit = $this->unitModel->findOrFail($unitId);
            $servicesData = $request->input('services', []);
            $validatedData = $request->validate([
                'services' => 'required|array',
                'services.*' => 'exists:services,id',
            ]);

            $unit->services = $validatedData['services'];
            $unit->save();
            return redirect()->route('units.index')->with('success', 'Serviços atualizados com sucesso.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('units.index')->with('error', 'Unidade não encontrada.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar serviços: ' . $e->getMessage());
        }
    }
}
