<?php

namespace App\Services\Conference;

use App\Enums\ConferenceRoom;
use App\Enums\Status;
use App\Models\ConferenceRequest;
use Illuminate\Contracts\Pagination\Paginator;

interface ConferenceRequestManager
{
    public function setConferenceRequest(ConferenceRequest $conferenceRequest): self;
    public function search(int $perPage = 20): Paginator;
    public function create(array $payload): ?ConferenceRequest;
    public function update(array $payload): ConferenceRequest;
    public function addSignatories(array $payload);
    public function updateStatus(Status $status): ConferenceRequest;
}
