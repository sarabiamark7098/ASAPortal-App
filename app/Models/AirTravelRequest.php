<?php

namespace App\Models;

use App\Enums\Status;
use App\QueryFilters\AirTravelRequest\SearchFilter;
use App\QueryFilters\Generic\SortFilter;
use App\QueryFilters\Generic\StatusFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;

class AirTravelRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'requesting_office',
        'date_requested',
        'fund_source',
        'trip_type',
        'requester_name',
        'requester_position',
        'requester_contact_number',
        'requester_email',
        'status',
    ];

    protected $casts = [
        'date_requested' => 'date:Y-m-d',
        'status' => Status::class,
    ];

    protected $with = [
        'signable:signable_id,label,full_name,position',
        'passenger:first_name,last_name,birth_date,position,email,contact_number',
        'flight:destination,date_departure,departure_etd,departure_eta,date_arrival,arrival_etd,arrival_eta',
    ];

     protected static function boot(): void
    {
        parent::boot();

        static::created(function (VehicleRequest $model) {
            $model->control_number = date('Y-m-').str_pad($model->id, 6, '0', STR_PAD_LEFT);
            $model->status = Status::PENDING;
            $model->save();
        });
    }

    public function transactable(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactable');
    }

    public function signable(): MorphMany
    {
        return $this->morphMany(FormSignatory::class, 'signable');
    }

    public function passenger()
    {
        return $this->morphMany(FormPassenger::class, 'passenger');
    }

    public function flight()
    {
        return $this->morphMany(FormFlight::class, 'flight');
    }

    /**
     * @Scope
     * Pipeline for HTTP query filters
     */
    public function scopeFiltered(Builder $builder): Builder
    {
        return app(Pipeline::class)
            ->send($builder)
            ->through([
                StatusFilter::class,
                SortFilter::class,
                SearchFilter::class,
            ])
            ->thenReturn();
    }
}
