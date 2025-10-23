<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\AirTransportRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AirTransportRequestPolicy
{
    public function process(User $user, AirTransportRequest $airTransportRequest): Response
    {
        if ($airTransportRequest->status == Status::PENDING) {
            return Response::allow();
        }
        return Response::deny('The air transport order request is on proccess.');
    }

    public function update(User $user, AirTransportRequest $airTransportRequest): Response
    {
        if ($airTransportRequest->status == Status::PROCESSED) {
            return Response::allow();
        }
        return Response::deny('The air transport order request is not yet processed.');
    }
}
