<?php

namespace App\Services;
use App\Models\UnitModel;
use Illuminate\Http\Request;

class UnitService extends MyBaseService
{
    public function renderTimesInterval(?string $serviceTime = null): string
    {
        $options = [];
        foreach (self::$serviceTimes as $key => $time){
            $options[$key] = $time;
        }
        return form_dropdown(data: 'servicetime', options: $options, selected: old('servicetime', $serviceTime), extra: ['class' => 'form-control']);
    }
    public function getAllUnitsFormatted($perPage = 10, $search = null)
    {
        return $this->handleExceptions(function() use ($perPage, $search) {
            $query = UnitModel::query();

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%");
                });
            }

            $units = $query->paginate($perPage);

            $table = new \stdClass();
            $table->headers = ['Ações', 'Nome', 'E-mail', 'Telefone', 'Status','Início', 'Fim', 'Criado'];
            $table->rows = [];
            $table->isEmpty = true;

            if (!$units->isEmpty()) {
                $table->rows = $units->map(function ($unit) {
                    $statusLabel = $unit->active ? '<span class="badge badge-success">Ativado</span>' : '<span class="badge badge-danger">Desativado</span>';
                    return [
                        'actions'    => $this->renderBtnActions($unit),
                        'name'       => $unit->name,
                        'email'      => $unit->email,
                        'phone'      => $unit->phone,
                        'status'     => $statusLabel,
                        'starttime'  => $unit->starttime,
                        'endtime'    => $unit->endtime,
                        'created_at' => MyBaseService::formatDateTime($unit->created_at),
                    ];
                });
                $table->isEmpty = false;
            }

            return $table;
        });
    }

    public function sanitizeInput(array $input)
    {
        return array_map(function ($value) {
            // Strip HTML tags to prevent XSS
            $value = strip_tags($value);

            // Remove script tags or any potentially malicious JavaScript code
            $value = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $value);

            // Allow alphanumeric characters, spaces, and specific symbols: @ . ( ) -
            // Note: \p{L} matches any letter, \p{N} matches any number, \s matches any whitespace character
            $value = preg_replace('/[^\p{L}\p{N}\s@.:\(\)-]/u', '', $value);

            // Replace multiple spaces with a single space
            $value = preg_replace('/\s+/', ' ', $value);

            // Trim the string to remove spaces at the beginning and end
            $value = trim($value);

            return $value;
        }, $input);
    }


    public function validateUnit(Request $request)
    {
        $messages = [
            'name.required'         => 'O campo nome é obrigatório.',
            'name.max'              => 'O nome não pode ter mais que 255 caracteres.',
            'email.required'        => 'O campo e-mail é obrigatório.',
            'email.email'           => 'Informe um e-mail válido.',
            'password.required'     => 'O campo senha é obrigatório.',
            'phone.max'             => 'O telefone não pode ter mais que 11 dígitos.',
            'phone.numeric'         => 'O telefone deve conter apenas números.',
            'coordinator.max'       => 'O coordenador não pode ter mais que 255 caracteres.',
            'address.max'           => 'O endereço não pode ter mais que 255 caracteres.',
            'starttime.date_format' => 'Formato de hora de início inválido. Use o formato HH:mm.',
            'endtime.date_format'   => 'Formato de hora de fim inválido. Use o formato HH:mm.',
            'active.boolean'        => 'O campo ativo deve ser verdadeiro ou falso.'
        ];

        return $request->validate([
            'name'        => 'required|max:255',
            'email'       => 'required|email',
            'password'    => 'required',
            'phone'       => 'nullable|max:30',
            'coordinator' => 'nullable|max:255',
            'address'     => 'nullable|max:255',
            'starttime'   => 'nullable|date_format:H:i',
            'endtime'     => 'nullable|date_format:H:i',
            'servicetime' => 'nullable|string',
            'active'      => 'nullable|boolean'
        ], $messages);
    }

    public function editUnit($id)
    {
        return $this->handleExceptions(function() use ($id) {
            return UnitModel::findOrFail($id);
        });
    }

    private function renderBtnActions(UnitModel $unit): string
    {
        $btnActions = '<div class="btn-group">';
        $btnActions .= '<button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações</button>';
        $btnActions .= '<div class="dropdown-menu">';
        $btnActions .= '<a class="dropdown-item" href="' . route('units.edit', $unit->id) . '">Editar</a>';
        if ($unit->active) {
            $btnActions .= '<a class="dropdown-item" href="' . route('units.toggleStatus', $unit->id) . '">Desativar</a>';
            $btnActions .= '<a class="dropdown-item" href="' . route('units.services', $unit->id) . '">Serviços</a>';

        } else {
            $btnActions .= '<a class="dropdown-item" href="' . route('units.toggleStatus', $unit->id) . '">Ativar</a>';
        }
        $btnActions .= '<a class="dropdown-item text-danger" href="#" data-id="' . $unit->id . '" data-toggle="modal" data-target="#confirmDeleteModal' . $unit->id . '" onclick="setDeleteUrl(this)">Excluir</a>';
        $btnActions .= '</div></div>';
        return $btnActions;
    }




}
