<?php

namespace App\QueryFilters\Generic;

use App\QueryFilters\Filter;
use Illuminate\Database\Eloquent\Builder;

class DeleteFilter extends Filter
{
    private const FILTER_NAME = 'deleted';

    protected function applyFilter(Builder $builder): Builder
    {
        $filterName = $this->getFilterName();

        if (request($filterName) == true) {
            return $builder->onlyTrashed();
        }

        return $builder;
    }

    protected function getFilterName(): string
    {
        return static::FILTER_NAME;
    }
}
