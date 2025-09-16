<?php

namespace App\Models;

use App\QueryFilters\Generic\SortFilter;
use App\QueryFilters\Signatory\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;

class Signatory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'position',
    ];

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
