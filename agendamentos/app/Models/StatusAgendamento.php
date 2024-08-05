<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAgendamento extends Model
{
use HasFactory;

protected $table = 'status_agendamento';

public function schedules()
{
return $this->hasMany(Schedule::class, 'status_id');
}
}
