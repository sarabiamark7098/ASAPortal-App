<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class VehicleService implements VehicleManager
{
    public Model $model;

    public function __construct(Vehicle $model)
    {
        $this->model = $model;
    }
    public function search(int $perPage = 20): Paginator
    {
        return $this->model->filtered()->paginate($perPage);
    }


}
