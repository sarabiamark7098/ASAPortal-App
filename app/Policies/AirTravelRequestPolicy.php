<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\AirTravelRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AirTravelRequestPolicy
{
    public function process(User $user, AirTravelRequest $airTravelRequest): Response
    {
        if ($airTravelRequest->status == Status::PENDING) {
            return Response::allow();
        }
        return Response::deny('The air travel order request is on proccess.');
    }

    public function update(User $user, AirTravelRequest $airTravelRequest): Response
    {
        if ($airTravelRequest->status == Status::PROCESSED) {
            return Response::allow();
        }
        return Response::deny('The air travel order request is not yet processed.');
    }
}
