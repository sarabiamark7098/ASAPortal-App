<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFlight extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'destination_from',
        'destination_to',
        'trip_mode',
        'departure_date',
        'etd',
        'eta',
    ];

}
