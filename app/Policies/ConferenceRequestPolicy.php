<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\User;
use App\Models\ConferenceRequest;
use Illuminate\Auth\Access\Response;

class ConferenceRequestPolicy
{
    public function process(User $user, ConferenceRequest $conferenceRequest): Response
    {
        if ($conferenceRequest->status == Status::PENDING) {
            return Response::allow();
        }
        return Response::deny('The conference request is on proccess.');
    }
    public function update(User $user, ConferenceRequest $conferenceRequest): Response
    {
        if ($conferenceRequest->status == Status::PROCESSED) {
            return Response::allow();
        }
        return Response::deny('The conference request is on proccess.');
    }
}
