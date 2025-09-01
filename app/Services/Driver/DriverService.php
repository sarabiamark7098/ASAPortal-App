<?php

namespace App\Services\Driver;

use App\Models\Driver;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class DriverService implements DriverManager
{
    public Model $model;

    private Driver $driver;

    public function __construct(Driver $model)
    {
        $this->model = $model;
    }
    public function search(int $perPage = 20): Paginator
    {
        return $this->model->filtered()->paginate($perPage);
    }


}
