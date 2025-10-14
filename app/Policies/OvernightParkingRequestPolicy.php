<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\User;
use App\Models\OvernightParkingRequest;
use Illuminate\Auth\Access\Response;

class OvernightParkingRequestPolicy
{
    public function process(User $user, OvernightParkingRequest $overnightParkingRequest): Response
    {
        if ($overnightParkingRequest->status == Status::PENDING) {
            return Response::allow();
        }
        return Response::deny('The overnight parking request is on process.');
    }

    public function update(User $user, OvernightParkingRequest $overnightParkingRequest): Response
    {
        if ($overnightParkingRequest->status == Status::PROCESSED) {
            return Response::allow();
        }
        return Response::deny('The overnight parking request is not yet processed.');
    }
}
