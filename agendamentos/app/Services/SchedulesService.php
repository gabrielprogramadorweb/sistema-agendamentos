<?php
namespace App\Services;
use App\Models\ServiceModel;
use App\Models\UnitModel;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Log;

class SchedulesService
{
    // Renderiza a lista com as opções de unidades ativas para serem escolhidas no agendamento.
    public function renderUnits(): string
    {
        $output = '';
        try {
            $units = UnitModel::where('active', 1)
                ->whereNotNull('services')
                ->where('services', '!=', '[]')
                ->orderBy('name', 'ASC')
                ->get();

            if ($units->isEmpty()) {
                $output = '<div class="text-info mt-5">' . __('Não há Unidades disponíveis para agendamentos') . '</div>';
                $output .= '<a href="' . route('services.index') . '" class="btn btn-sm btn-outline-primary">' . __('View services') . '</a>';
            } else {
                $radios = '';
                foreach ($units as $unit) {
                    $checked = ''; // Add logic here if you need to pre-select any radio button
                    $radios .= '<div class="form-check mb-2">';
                    $radios .= "<input type='radio' name='unit_id' data-name='{$unit->name }'  data-address='{$unit->address}' value='{$unit->id}' class='form-check-input' id='radio-unit-{$unit->id}'>";
                    $radios .= "<label class='form-check-label' for='radio-unit-{$unit->id}'>{$unit->name} - {$unit->address}</label>";
                    $radios .= '</div>';
                }
                $output .= $radios;
            }
            return $output;
        } catch (\Exception $e) {
            Log::error("Error rendering service options: " . $e->getMessage());
            return '<div class="alert alert-danger">' . __('Error loading services.') . '</div>';
        }
    }
    //Recupera os serviços ssociados à unidade informada
    public function renderUnitServices(int $unitId): string
    {
        $unit = UnitModel::where('active', 1)->findOrFail($unitId);
        $serviceIds = json_decode($unit->services, true);

        if (empty($serviceIds)) {
            Log::warning("No service IDs found for unit {$unitId}");
            return "No services available"; // Simple text or you can choose to throw an exception
        }

        $services = ServiceModel::whereIn('id', $serviceIds)->where('active', 1)->get();
        if ($services->isEmpty()) {
            Log::info("No active services found for unit {$unit->name}");
            return "No active services available";
        }

        $options = '<option value="">Select Service</option>';
        foreach ($services as $service) {
            $options .= "<option value='{$service->id}'>{$service->name}</option>";
        }
        return $options;
    }

    public function getUnitServices(int $unitId)
    {
        try {
            $unit = UnitModel::where('active', 1)->findOrFail($unitId);
            $serviceIds = json_decode($unit->services, true);

            // Flatten the array if it's nested
            if (is_array($serviceIds) && count($serviceIds) && is_array($serviceIds[0])) {
                $serviceIds = array_column($serviceIds, 'id'); // Adjusting based on the structure
            }

            if (empty($serviceIds)) {
                Log::warning("No service IDs found for unit {$unitId}");
                return []; // Return an empty array indicating no services
            }

            $services = ServiceModel::whereIn('id', $serviceIds)->where('active', 1)->get();
            return $services;
        } catch (\Exception $e) {
            Log::error("Failed to retrieve services for unit {$unitId}: " . $e->getMessage());
            throw $e; // Re-throw the exception to be handled by the controller
        }
    }




}
