<?php

namespace App\QueryFilters\VehicleRequest;

use App\QueryFilters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter extends Filter
{
    private const FILTER_NAME = 'query';

    protected function applyFilter(Builder $builder): Builder
    {
        $filterName = $this->getFilterName();

        $keywords = request($filterName);

        return $builder->where(function($builder) use ($keywords) {
            $builder->orWhereFullText('requesting_office', $keywords);
            $builder->orWhereFullText('purpose', $keywords);
            $builder->orWhereFullText('passengers', $keywords);
            $builder->orWhereFullText('destination', $keywords);
            $builder->orWhereFullText('requester_name', $keywords);
            $builder->orWhere('control_number', 'like', "%$keywords%");
        });
    }

    protected function getFilterName(): string
    {
        return static::FILTER_NAME;
    }
}
