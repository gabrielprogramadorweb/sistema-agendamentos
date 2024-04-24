<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'units';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'coordinator',
        'address',
        'starttime',
        'endtime',
        'servicetime',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    protected $dates = ['deleted_at'];

    protected array $cast = [
        'services' => 'array',
    ];

    // Assuming 'services' contains an array of service IDs
    public function getServicesAttribute()
    {
        if ($this->attributes['services']) {
            return ServiceModel::whereIn('id', $this->attributes['services'])->get();
        }
        return collect(); // Return an empty collection if there are no services
    }


}
