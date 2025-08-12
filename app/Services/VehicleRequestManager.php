<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use App\Models\VehicleRequest;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface VehicleRequestManager {
    public function setVehicleRequest(VehicleRequest $vehicleRequest) : self;
    public function search(int $perPage = 20) : Paginator;
    public function create(array $payload) : ?VehicleRequest;
    public function update(array $payload) : VehicleRequest;
    public function assignVehicle(VehicleAssignment $vehicleAssignment) : VehicleRequest;
    public function addSignatories(array $payload);
    public function updateStatus(Status $status) : VehicleRequest;
}