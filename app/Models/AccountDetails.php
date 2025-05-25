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
    ];

    public function section()
    {
        return $this->belongsTo(Sections::class, 'section_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
