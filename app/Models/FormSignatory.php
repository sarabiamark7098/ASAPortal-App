<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSignatory extends Model
{
    protected $fillable = [
        'label',
        'full_name',
        'position',
    ];
}
