<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $dates = ['created_at', 'updated_at', 'chosen_date']; // Correção do typo em 'update_at' para 'updated_at'
    protected $fillable = [
        'user_id', 'service_id', 'unit_id', 'date', 'time',
    ];
    protected $casts = [
        'finished' => 'boolean',
        'canceled' => 'boolean',
    ];

    /**
     * Formata a data e hora de atualização.
     *
     * @return string
     */
    public function getFormattedUpdatedAt(): string
    {
        return $this->updated_at->format('d-m-Y H:i');
    }

    /**
     * Determina a situação do agendamento.
     *
     * @return string
     */
    public function getSituation(): string
    {
        if ($this->finished) {
            return 'Finalizado em ' . $this->getFormattedUpdatedAt();
        }
        if ($this->canceled) {
            return 'Cancelado em ' . $this->getFormattedUpdatedAt();
        }

        $isBefore = $this->chosen_date->isBefore(now());
        return $isBefore ? "Ocorreu em " . $this->chosen_date->format('d-m-Y H:i') : "Será em " . $this->chosen_date->format('d-m-Y H:i');
    }

    /**
     * Verifica se o agendamento pode ser cancelado.
     *
     * @return bool
     */
    public function canBeCanceled(): bool
    {
        return !$this->finished && !$this->canceled && $this->chosen_date->isFuture();
    }

    // Em app/Models/Schedule.php

    public function unit()
    {
        return $this->belongsTo(UnitModel::class);
    }

    public function service()
    {
        return $this->belongsTo(ServiceModel::class);
    }

}
