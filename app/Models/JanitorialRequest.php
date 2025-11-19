<?php

namespace App\Models;

use App\Enums\Status;
use App\QueryFilters\Generic\SortFilter;
use App\QueryFilters\Generic\StatusFilter;
use App\QueryFilters\JanitorialRequest\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;

class JanitorialRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'date_requested',
        'requesting_office',
        'control_number',
        'purpose',
        'count_utility',
        'requested_date',
        'requested_time',
        'location',
        'fund_source',
        'office_head',
        'requester_name',
        'requester_position',
        'requester_contact_number',
        'requester_email',
        'status',
    ];

    protected $casts = [
        'date_requested' => 'date:Y-m-d',
        'request_type' => 'array',
        'request_nature' => 'array',
        'status' => Status::class,
    ];

    protected $with = [
        'signable:signable_id,label,full_name,position',
        'janitorable:janitorable_id,full_name',
        'fileable:fileable_id,label,filename,path',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (JanitorialRequest $model) {
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
    public function janitorable(): MorphMany
    {
        return $this->morphMany(FormJanitor::class, 'janitorable');
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
            ])
            ->thenReturn();
    }
}
