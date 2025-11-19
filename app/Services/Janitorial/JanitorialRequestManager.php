<?php

namespace App\Services\Janitorial;

use App\Enums\Status;
use App\Models\JanitorialRequest;
use Illuminate\Contracts\Pagination\Paginator;

interface JanitorialRequestManager
{
    public function setJanitorialRequest(JanitorialRequest $janitorialRequest): self;
    public function search(int $perPage = 20): Paginator;
    public function create(array $payload): ?JanitorialRequest;
    public function update(array $payload): JanitorialRequest;
    public function addSignatories(array $payload);
    public function addJanitors(array $payload);
    public function updateStatus(Status $status): JanitorialRequest;
}
