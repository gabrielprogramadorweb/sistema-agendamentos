<?php
namespace App\Services;

use App\Models\UnitModel;

class UnitService extends MyBaseService
{
    public function getAllUnitsFormatted()
    {
        return $this->handleExceptions(function() {
            $units = $this->getAll(UnitModel::class);
            $table = new \stdClass();
            $table->headers = ['Nome', 'E-mail', 'Telefone', 'Início', 'Fim', 'Criado'];
            $table->rows = $units->map(function ($unit) {
                return [
                    'name' => $unit->name,
                    'email' => $unit->email,
                    'phone' => $unit->phone,
                    'starttime' => $unit->starttime,
                    'endtime' => $unit->endtime,
                    'created_at' => $unit->created_at->toDateTimeString()
                ];
            });
            return $table;
        });
    }
}
