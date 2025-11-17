<?php

namespace App\Models;

use App\Enums\ConferenceRoom;
use App\Enums\Status;
use App\QueryFilters\ConferenceRequest\SearchFilter;
use App\QueryFilters\Generic\RoomFilter;
use App\QueryFilters\Generic\SortFilter;
use App\QueryFilters\Generic\StatusFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;

class ConferenceRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date_requested',
        'requesting_office',
        'control_number',
        'purpose',
        'requested_start',
        'requested_time_start',
        'requested_end',
        'requested_time_end',
        'conference_room',
        'number_of_persons',
        'focal',
        'requester_name',
        'requester_position',
        'requester_contact_number',
        'requester_email',
        'is_conference_available',
        'status'
    ];

    protected $casts = [
        'date_requested' => 'date:Y-m-d',
        'requested_start' => 'date:Y-m-d',
        'requested_time_start' => 'datetime:H:i:s',
        'requested_end' => 'date:Y-m-d',
        'requested_time_end' => 'datetime:H:i:s',
        'conference_room' => ConferenceRoom::class,
        'is_conference_available' => 'boolean',
        'status' => Status::class,
    ];

    protected $with = [
        'signable:signable_id,label,full_name,position',
        'fileable:fileable_id,label,filename,path',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (ConferenceRequest $model) {
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

    public function fileable(): MorphMany
    {
        return $this->morphMany(FormFileUpload::class, 'fileable');
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
                RoomFilter::class,
            ])
            ->thenReturn();
    }
}
