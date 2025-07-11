<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountDetails extends Model
{
    protected $fillable = [
        'firstName',
        'lastName',
        'middleName',
        'extensionName',
        'position',
        'birthDate',
        'contactNumber',
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
