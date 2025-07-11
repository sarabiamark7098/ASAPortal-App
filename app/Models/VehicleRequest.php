<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleRequest extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'date_requested',
        'control_number',
        'purpose',
        'requested_start',
        'requested_end',
        'destination',
        'requester_name',
        'requester_position',
        'requester_contact_number',
        'requester_email',
    ];

    protected $casts = [
        'date_requested' => 'date:Y-m-d',
        'requested_start' => 'datetime',
        'requested_end' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (VehicleRequest $model) {
            $model->control_number = date('Y-m-').str_pad($model->id, 6, '0', STR_PAD_LEFT);
        });
    }

    public function transactable() : MorphOne {
        return $this->morphOne(Transaction::class, 'transactable');
    }
}
