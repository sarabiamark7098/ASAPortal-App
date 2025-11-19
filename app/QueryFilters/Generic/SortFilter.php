<?php

namespace App\QueryFilters\Generic;

use App\QueryFilters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SortFilter extends Filter
{
    private const FILTER_NAME = 'sort_by';

    protected function applyFilter(Builder $builder): Builder
    {
        $filterName = $this->getFilterName();

        $sortBy = request($filterName);
        $sortOrder = request('sort_order') ?? 'asc';
        if (! $sortBy) {
            return $builder->orderBy('id', $sortOrder);
        }

        return $builder->orderBy($sortBy, $sortOrder);
    }

    protected function getFilterName(): string
    {
        return static::FILTER_NAME;
    }
}
