<?php

namespace App\Services;

use App\Models\UnitModel;

class UnitService extends MyBaseService
{
    private static array $serviceTimes = [
        '10 minutes' => '10 minutos',
        '15 minutes' => '15 minutos',
        '30 minutes' => '30 minutos',
        '1 hour'     => '1 hora',
        '2 hour'     => '2 horas',
    ];

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
            $table->headers = ['Ações', 'Nome', 'E-mail', 'Telefone', 'Início', 'Fim', 'Criado'];
            $table->rows = [];
            $table->isEmpty = true;

            if (!$units->isEmpty()) {
                $table->rows = $units->map(function ($unit) {
                    return [
                        'actions' => $this->renderBtnActions($unit),
                        'name' => $unit->name,
                        'email' => $unit->email,
                        'phone' => $unit->phone,
                        'starttime' => $unit->starttime,
                        'endtime' => $unit->endtime,
                        'created_at' => $unit->created_at->toDateTimeString()
                    ];
                });
                $table->isEmpty = false;
            }

            return $table;
        });
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
        $btnActions .= '<a class="dropdown-item" href="' . route('units.edit', $unit->id) . '">Edit</a>';
        $btnActions .= '<a class="dropdown-item" href="#">Ação2</a>';
        $btnActions .= '<a class="dropdown-item" href="#">Ação3</a>';
        $btnActions .= '</div></div>';
        return $btnActions;
    }
}
