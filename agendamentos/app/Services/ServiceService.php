<?php

namespace App\Services;
use App\Models\ServiceModel;
use App\Models\UnitModel;
use Illuminate\Http\Request;

class ServiceService extends MyBaseService
{

    public function handleExceptions($callback)
    {
        try {
            return $callback();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw $e;
        }
    }

    public function getAllServicesFormatted($services)
    {
        return $this->handleExceptions(function() use ($services) {
            $table = new \stdClass();
            $table->headers = ['Ações', 'Nome', 'Status', 'Criado'];
            $table->rows = [];
            $table->isEmpty = true;

            if (!$services->isEmpty()) {
                $table->rows = $services->map(function ($service) {
                    $statusLabel = $service->active ? '<span class="badge badge-success">Ativado</span>' : '<span class="badge badge-danger">Desativado</span>';
                    return [
                        'actions'    => $this->renderBtnActions($service),
                        'name'       => $service->name,
                        'status'     => $statusLabel,
                        'created_at' => MyBaseService::formatDateTime($service->created_at),
                    ];
                })->toArray();
                $table->isEmpty = false;
            }

            return $table;
        });
    }
    public function renderTimesInterval(?string $serviceTime = null): string
    {
        $options = [];
        foreach (self::$serviceTimes as $key => $time){
            $options[$key] = $time;
        }
        return form_dropdown(data: 'servicetime', options: $options, selected: old('servicetime', $serviceTime), extra: ['class' => 'form-control']);
    }

    public function sanitizeInput(array $input)
    {
        // Aplica a função de sanitização em cada valor do array de input
        return array_map(function ($value) {
            // Remove tags HTML e PHP
            $value = strip_tags($value);
            // Remove caracteres especiais
            $value = preg_replace('/[^\p{L}\p{N}\s]/u', '', $value);
            // Remove espaços extras
            $value = trim(preg_replace('/\s+/', ' ', $value));

            return $value;
        }, $input);
    }

    public function validateService(Request $request)
    {
        $messages = [
            'name.required'         => 'O campo nome é obrigatório.',
            'name.max'              => 'O nome não pode ter mais que 255 caracteres.',
            'active.boolean'        => 'O campo ativo deve ser verdadeiro ou falso.'
        ];

        return $request->validate([
            'name'        => 'required|max:255',
            'active'      => 'nullable|boolean'
        ], $messages);
    }

    public function editUnit($id)
    {
        return $this->handleExceptions(function() use ($id) {
            return ServiceModel::findOrFail($id);
        });
    }

    private function renderBtnActions(ServiceModel $service): string
    {
        $btnActions = '<div class="btn-group">';
        $btnActions .= '<button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações</button>';
        $btnActions .= '<div class="dropdown-menu">';
        $btnActions .= '<a class="dropdown-item" href="' . route('services.edit', $service->id) . '">Editar</a>';
        if ($service->active) {
            $btnActions .= '<a class="dropdown-item" href="' . route('services.toggleStatus', $service->id) . '">Desativar</a>';
        } else {
            $btnActions .= '<a class="dropdown-item" href="' . route('services.toggleStatus', $service->id) . '">Ativar</a>';
        }
        $btnActions .= '<a class="dropdown-item text-danger" href="#" data-id="' . $service->id . '" data-toggle="modal" data-target="#confirmDeleteModal' . $service->id . '" onclick="setDeleteUrl(this)">Excluir</a>';
        $btnActions .= '</div></div>';
        return $btnActions;
    }




}
