<?php

namespace App\Services;

use App\Models\UnitModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SchedulesService
{
    // Renderiza a lista com as opções de unidades ativas para serem escolhidas no agendamento.
    public function renderUnits(): string
    {
        $output = '';
        try {
            // Query units that are active and have associated services
            $units = UnitModel::where('active', 1)
                ->whereNotNull('services')
                ->where('services', '!=', '[]') // Ensure services field is not an empty array
                ->orderBy('name', 'ASC')
                ->get();

            if ($units->isEmpty()) {
                $output = '<div class="text-info mt-5">' . __('Não há Unidades disponíveis para agendamentos') . '</div>';
                $output .= '<a href="' . route('services.index') . '" class="btn btn-sm btn-outline-primary">' . __('View services') . '</a>';
            } else {
                $radios = '';
                foreach ($units as $unit) {
                    $checked = ''; // You might need logic to determine if something should be checked
                    $radios .= '<div class="form-check mb-2">';
                    $radios .= "<input type='radio' name='unit_id' value='{$unit->id}' class='form-check-input' id='radio-unit-{$unit->id}'>";
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
}

