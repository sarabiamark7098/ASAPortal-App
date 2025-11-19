<?php

namespace App\Models;

use App\QueryFilters\Generic\SortFilter;
use App\QueryFilters\Driver\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;

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
        return trim($this->first_name . " " . (!empty($this->middle_name[0])?$this->middle_name[0].". ": "") . $this->last_name . " " . (!empty($this->extension_name)?$this->extension_name: ""));
    }

    public function scopeFiltered(Builder $builder): Builder
    {
        return app(Pipeline::class)
            ->send($builder)
            ->through([
                SortFilter::class,
                SearchFilter::class,
            ])
            ->thenReturn();
    }

    
}
