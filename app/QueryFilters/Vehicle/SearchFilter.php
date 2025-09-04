<?php

namespace App\QueryFilters\Vehicle;

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
            $builder->where('plate_number', 'like', "%$keywords%");
            $builder->orWhere('unit_type', 'like', "%$keywords%");
            $builder->orWhere('brand', 'like', "%$keywords%");
            $builder->orWhere('model', 'like', "%$keywords%");
        });
    }

    protected function getFilterName(): string
    {
        return static::FILTER_NAME;
    }
}
