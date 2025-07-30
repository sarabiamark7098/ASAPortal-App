<?php

namespace App\Services;

use App\Models\VehicleRequest;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class VehicleRequestService implements VehicleRequestManager
{
    public Model $model;
    
    public function __construct(VehicleRequest $model)
    {
        $this->model = $model;
    }

    public function fetch() : Collection {
        return $this->model->all();
    }
    
    public function search(int $perPage = 20) : Paginator {
        return $this->model->filtered()->paginate($perPage);
    }

    public function create(array $payload) : VehicleRequest {
        $vehicleRequest = $this->model->create($payload);

        $vehicleRequest->transactable()->create([
            'user_id' => $payload['user_id'],
        ]);

        return $vehicleRequest;
    }
}
