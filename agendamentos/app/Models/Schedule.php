<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Time;

class Schedule extends Model
{
    /**
     * Get the validation rules that apply to the schedule.
     *
     * @return array
     */
    protected $dates = ['created_at', 'update_at'];
    protected $casts = [
        'finished' => 'boolean',
        'canceled' => 'boolean',
    ];

    public function updatedAt():string
    {
        return Carbon::parse($this->updated_at)->format('d-m-Y H:i');
    }

    public function situation(): string
    {
        if ($this->finished){
            return 'Finalizado em {$$this->>updatedAt()}';
        }
       if ($this->canceled){
            return 'Cancelado em {$$this->>updatedAt()}';
        }

       $isBefore = Carbon::parse($this->chosen_date)->isBefore(Carbon::now());

       return $isBefore ? `Ocorreu em {$this->formated_chosen_date}` : `Será em {$this->formated_chosen_date}`;
    }
    public function canBeCanceled(): bool
    {
        if ($this->finished || $this->canceled){
            return false;
        }
        return Carbon::parse($this->chosen_date)->isAfter(Carbon::now());
    }

}

