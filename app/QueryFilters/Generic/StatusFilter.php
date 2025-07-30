<?php

namespace App\QueryFilters\Generic;

use App\QueryFilters\Filter;
use Illuminate\Database\Eloquent\Builder;

class StatusFilter extends Filter
{
    private const FILTER_NAME = 'status';

    protected function applyFilter(Builder $builder): Builder
    {
        $filterName = $this->getFilterName();

        return $builder->where('status', request($filterName));
    }

    protected function getFilterName(): string
    {
        return static::FILTER_NAME;
    }
}
