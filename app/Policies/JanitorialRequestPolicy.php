<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\User;
use App\Models\JanitorialRequest;
use Illuminate\Auth\Access\Response;

class JanitorialRequestPolicy
{
    public function process(User $user, JanitorialRequest $janitorialRequest): Response
    {
        if ($janitorialRequest->status == Status::PENDING) {
            return Response::allow();
        }
        return Response::deny('The janitorial request is on process.');
    }

    public function update(User $user, JanitorialRequest $janitorialRequest): Response
    {
        if ($janitorialRequest->status == Status::PROCESSED) {
            return Response::allow();
        }
        return Response::deny('The janitorial request is not yet processed.');
    }
}
