<?php

namespace App\Models;

use App\Enums\VehicleUnitType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'plate_number',
        'unit_type',
        'brand',
        'model',
        'purchase_year',
        'model_year',
        'engine_number',
        'chasis_number',
    ];

    protected $casts = [
        'unit_type' => VehicleUnitType::class,
    ];
}
