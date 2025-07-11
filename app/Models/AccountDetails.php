<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountDetails extends Model
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

    public function section()
    {
        return $this->belongsTo(Offices::class, 'office_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
