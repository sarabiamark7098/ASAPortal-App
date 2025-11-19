<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormPassenger extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'position',
        'email',
        'contact_number'
    ];
}
