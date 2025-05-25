<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisions extends Model
{
    protected $fillable = ['name'];

    public function sections()
    {
        return $this->hasMany(Sections::class);
    }

}
