<?php

namespace App\Services\Vehicle;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;

interface VehicleAssignmentManager
{
    public function create(Vehicle $vehicle, Driver $driver): VehicleAssignment;
}
