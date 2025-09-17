<?php

namespace App\Services\Assistance;

use App\Enums\Status;
use App\Models\AssistanceRequest;
use Illuminate\Contracts\Pagination\Paginator;

interface AssistanceRequestManager
{
    public function setAssistanceRequest(AssistanceRequest $assistanceRequest): self;
    public function search(int $perPage = 20): Paginator;
    public function create(array $payload): ?AssistanceRequest;
    public function update(array $payload): AssistanceRequest;
    public function addSignatories(array $payload);
    public function updateStatus(Status $status): AssistanceRequest;
}
