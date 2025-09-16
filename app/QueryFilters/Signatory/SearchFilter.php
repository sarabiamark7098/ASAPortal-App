<?php

namespace App\QueryFilters\Signatory;

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
            $builder->where('full_name', 'like', "%$keywords%");
            $builder->orWhere('position', 'like', "%$keywords%");
        });
    }

    protected function getFilterName(): string
    {
        return static::FILTER_NAME;
    }
}
