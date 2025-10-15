<?php

namespace App\QueryFilters\Generic;

use App\QueryFilters\Filter;
use Illuminate\Database\Eloquent\Builder;

class RoomFilter extends Filter
{
    private const FILTER_NAME = 'room';

    protected function applyFilter(Builder $builder): Builder
    {
        $filterName = $this->getFilterName();

        return $builder->where('conference_room', request($filterName));
    }

    protected function getFilterName(): string
    {
        return static::FILTER_NAME;
    }
}
