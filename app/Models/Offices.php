<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offices extends Model
{
    protected $fillable = ['name', 'division_id'];

    public function division()
    {
        return $this->belongsTo(Offices::class, 'division_id', 'id');
    }
    public function accountDetail()
    {
        return $this->hasMany(AccountDetail::class, 'office_id');
    }
}
