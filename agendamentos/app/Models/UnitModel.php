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
        // Ensure the services attribute is decoded properly from JSON
        $servicesIds = json_decode($this->attributes['services'], true);

        // Check if $servicesIds is an array before querying
        if (is_array($servicesIds)) {
            return ServiceModel::whereIn('id', $servicesIds)->get();
        }

        // If $servicesIds is not an array, return an empty collection
        return collect();
    }

    public function setServicesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['services'] = json_encode($value);
        } else {
            $this->attributes['services'] = '[]'; // Default to an empty array as JSON
        }
    }

    public function services()
    {
        return $this->belongsToMany(ServiceModel::class, 'unit_service_table', 'unit_id', 'service_id');
    }





}
