<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\User;
use App\Models\VehicleRequest;
use Illuminate\Auth\Access\Response;

class VehicleRequestPolicy
{
    public function process(User $user, VehicleRequest $vehicleRequest): Response
    {
        if($vehicleRequest->status == Status::PENDING){
            return Response::allow();
        }

        return Response::deny('The vehicle request is on proccess.');
    }
}
