<?php

namespace App\QueryFilters\Driver;

use App\QueryFilters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter extends Filter
{
    private const FILTER_NAME = 'query';

    protected function applyFilter(Builder $builder): Builder
    {
        $filterName = $this->getFilterName();

        $keywords = request($filterName);

        return $builder->where(function ($builder) use ($keywords) {
            $builder->where('first_name', 'like', "%$keywords%");
            $builder->orWhere('last_name', 'like', "%$keywords%");
            $builder->orWhere('position', 'like', "%$keywords%");
            $builder->orWhere('contact_number', 'like', "%$keywords%");
        });
    }

    protected function getFilterName(): string
    {
        return static::FILTER_NAME;
    }
}
