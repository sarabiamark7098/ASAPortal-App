<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormFlight extends Model
{
    protected $fillable = [
        'destination_from',
        'destination_to',
        'trip_mode',
        'date',
        'etd',
        'eta',
    ];
}
