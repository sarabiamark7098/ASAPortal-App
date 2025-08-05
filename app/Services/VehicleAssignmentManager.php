<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use App\Models\VehicleRequest;

interface VehicleAssignmentManager {
    public function create(Vehicle $vehicle, Driver $driver) : VehicleAssignment;
}