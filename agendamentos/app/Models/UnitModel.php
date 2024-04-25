<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'units';

    // Define all attributes you expect to be mass assignable
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'coordinator',
        'address',
        'starttime',
        'endtime',
        'servicetime',
        'active',
        'services'
    ];

    protected $casts = [
        'active'   => 'boolean',
        'services' => 'array',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Custom accessor to get the services associated with the unit.
     * This assumes 'services' is stored as an array of IDs.
     */
    public function getServicesAttribute()
    {
        if (!empty($this->attributes['services'])) {
            $servicesIds = json_decode($this->attributes['services'], true);
            return ServiceModel::whereIn('id', $servicesIds)->get();
        }
        return collect();
    }
}
