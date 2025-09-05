<?php

namespace App\Models;

use App\Enums\VehicleUnitType;
use App\QueryFilters\Generic\SortFilter;
use App\QueryFilters\Vehicle\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;

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
        'chassis_number',
    ];

    protected $with = [
        'vehicleAssignment',
    ];

    protected $casts = [
        'unit_type' => VehicleUnitType::class,
    ];

    public function scopeFiltered(Builder $builder): Builder
    {
        return app(Pipeline::class)
            ->send($builder)
            ->through([
                SortFilter::class,
                SearchFilter::class,
            ])
            ->thenReturn();
    }

    public function vehicleAssignment()
    {
        return $this->hasOne(VehicleAssignment::class)->without('vehicle');
    }
}
