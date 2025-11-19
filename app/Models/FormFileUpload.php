<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormFileUpload extends Model
{
    protected $fillable = [
        'label',
        'filename',
        'path',
    ];
}
