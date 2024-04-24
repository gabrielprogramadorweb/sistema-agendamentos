<?php

namespace App\Services;

use App\Models\ServiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnitServiceService extends MyBaseService
{
    public function renderServicesOptions(?array $existingServicesIds = null): string
    {
        $output = '';
        try {
            $services = ServiceModel::orderBy('name', 'ASC')->get();

            if ($services->isEmpty()) {
                $output .= '<div class="text-info mt-5">' . __('No services available') . '</div>';
                $output .= '<a href="' . route('services.index') . '" class="btn btn-sm btn-outline-primary">' . __('View services') . '</a>';
            } else {
                $ul = '<ul class="list-group">';

                foreach ($services as $service) {
                    $checked = in_array($service->id, $existingServicesIds ?? []) ? 'checked' : '';
                    $serviceName = htmlspecialchars($service->name, ENT_QUOTES, 'UTF-8');
                    $serviceId = htmlspecialchars($service->id, ENT_QUOTES, 'UTF-8');

                    $checkbox = '<div class="custom-control custom-checkbox">';
                    $checkbox .= "<input type='checkbox' name='services[]' value='{$serviceId}' class='custom-control-input' id='service-{$serviceId}' {$checked}>";
                    $checkbox .= "<label class='custom-control-label' for='service-{$serviceId}'>{$serviceName}</label>";
                    $checkbox .= '</div>';

                    $ul .= "<li class='list-group-item'>{$checkbox}</li>";
                }

                $ul .= '</ul>';
                $output .= $ul;
            }

            return $output;
        } catch (\Exception $e) {
            Log::error("Error rendering service options: " . $e->getMessage());
            return '<div class="alert alert-danger">' . __('Error loading services.') . '</div>';
        }
    }
}

