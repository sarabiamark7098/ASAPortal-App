<?php

namespace App\QueryFilters\Generic;

use App\QueryFilters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ExcludeFilter extends Filter
{
    private const FILTER_NAME = 'exclude';

    private string $columnName;

    public function __construct()
    {
        $this->columnName = 'id';
    }

    protected function applyFilter(Builder $builder): Builder
    {
        $filterName = $this->getFilterName();

        return $builder->whereNotIn($this->columnName, (array) request($filterName));
    }

    protected function getFilterName(): string
    {
        return static::FILTER_NAME;
    }

    public function setColumnName(string $name): void
    {
        $this->columnName = $name;
    }
}
