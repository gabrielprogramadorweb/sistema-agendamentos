<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceModel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'name',
        'active'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'services' => 'array',
        'active' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string>
     */
    protected $dates = [
        'deleted_at', // For soft deletes
    ];
    protected static function booted()
    {
        static::created(function ($service) {
            $allUnitIds = \App\Models\UnitModel::all()->pluck('id');
            $service->units()->syncWithoutDetaching($allUnitIds);
        });
    }
    public function units()
    {
        return $this->belongsToMany(UnitModel::class, 'service_unit', 'service_id', 'unit_id');
    }


}
