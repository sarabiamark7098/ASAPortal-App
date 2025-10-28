<?php

namespace App\Services\Entry;

use App\Enums\Status;
use App\Models\EntryRequest;
use Illuminate\Contracts\Pagination\Paginator;

interface EntryRequestManager
{
    public function setEntryRequest(EntryRequest $entryRequest): self;
    public function search(int $perPage = 20): Paginator;
    public function create(array $payload): ?EntryRequest;
    public function update(array $payload): EntryRequest;
    public function addGuests(array $payload);
    public function addSignatories(array $payload);
    public function updateStatus(Status $status): EntryRequest;
}
