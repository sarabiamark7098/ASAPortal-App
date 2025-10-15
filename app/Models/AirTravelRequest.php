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
        'trip_ticket_type',
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
        'passengers',
        'flights',
    ];

     protected static function boot(): void
    {
        parent::boot();

        static::created(function (AirTravelRequest $model) {
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

    public function passengers()
    {
        return $this->hasMany(FormPassenger::class);
    }

    public function flights()
    {
        return $this->hasMany(related: FormFlight::class);
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
