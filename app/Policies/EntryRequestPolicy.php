<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\EntryRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EntryRequestPolicy
{
public function process(User $user, EntryRequest $entryRequest): Response
    {
        if ($entryRequest->status == Status::PENDING) {
            return Response::allow();
        }
        return Response::deny('The entry to premises request is on proccess.');
    }

    public function update(User $user, EntryRequest $entryRequest): Response
    {
        if ($entryRequest->status == Status::PROCESSED) {
            return Response::allow();
        }
        return Response::deny('The entry to premises request is not yet processed.');
    }
}
