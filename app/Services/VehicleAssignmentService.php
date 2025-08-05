<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use Illuminate\Database\Eloquent\Model;

class VehicleAssignmentService implements VehicleAssignmentManager
{
    public Model $model;
    
    public function __construct(VehicleAssignment $model)
    {
        $this->model = $model;
    }

    public function create(Vehicle $vehicle, Driver $driver) : VehicleAssignment {
        $vehicleAssignment = $this->model->create();

        $vehicleAssignment->vehicle()->associate($vehicle);
        $vehicleAssignment->driver()->associate($driver);

        $vehicleAssignment->save();

        return $vehicleAssignment->fresh();
    }
}
