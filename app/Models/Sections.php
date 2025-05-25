<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    protected $fillable = ['name', 'division_id'];

    public function division()
    {
        return $this->belongsTo(Divisions::class);
    }
    public function accountDetails()
    {
        return $this->hasMany(AccountDetails::class, 'section_id');
    }
}
