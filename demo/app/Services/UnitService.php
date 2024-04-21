<?php
namespace App\Services;

use App\Models\UnitModel;

class UnitService extends MyBaseService
{
    public function getAllUnitsFormatted()
    {
        return $this->handleExceptions(function() {
            $units = $this->getAll(UnitModel::class);  // Primeiro, obtenha todos os registros.

            $table = new \stdClass();
            $table->headers = ['Nome', 'E-mail', 'Telefone', 'Início', 'Fim', 'Criado'];
            $table->rows = [];
            $table->isEmpty = true; // Inicializa como verdadeiro para indicar que está vazia

            // Preenche as linhas somente se houver unidades
            if (!$units->isEmpty()) {
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
                $table->isEmpty = false; // Atualiza a flag para falso, pois há dados
            }

            return $table;
        });
    }
}

