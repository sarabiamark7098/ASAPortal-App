<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'extension_name',
        'position',
        'designation',
        'official_station',
        'email',
        'contact_number',
    ];
    protected $appends = [
        'full_name',
    ];
    public function getFullNameAttribute(): string
    {
        return $this->first_name . " " . (!empty($this->middle_name[0])?$this->middle_name[0].". ": "") . $this->last_name . " " . (!empty($this->extension_name)?$this->extension_name: "");
    }
}
