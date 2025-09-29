<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\User;
use App\Models\AssistanceRequest;
use Illuminate\Auth\Access\Response;

class AssistanceRequestPolicy
{
    public function process(User $user, AssistanceRequest $assistanceRequest): Response
    {
        if ($assistanceRequest->status == Status::PENDING) {
            return Response::allow();
        }
        return Response::deny('The technical assistance request is on proccess.');
    }
    public function update(User $user, AssistanceRequest $assistanceRequest): Response
    {
        if ($assistanceRequest->status == Status::PROCESSED) {
            return Response::allow();
        }
        return Response::deny('The technical assistance request is on proccess.');
    }
}
