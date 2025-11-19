<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountDetail extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'extension_name',
        'position',
        'birth_date',
        'contact_number',
        'user_id',
        'office_id',
    ];
    protected $appends = [
        'full_name',
    ];

    public function section()
    {
        return $this->belongsTo(Offices::class, 'office_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . " " . (!empty($this->middle_name[0])?$this->middle_name[0].". ": "") . $this->last_name . " " . (!empty($this->extension_name)?$this->extension_name: ""));
    }
}
