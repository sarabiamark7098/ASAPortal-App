<?php

namespace App\Services\AirTransport;

use App\Enums\Status;
use App\Models\AirTransportRequest;
use Illuminate\Contracts\Pagination\Paginator;

interface AirTransportRequestManager
{
    public function setAirTransportRequest(AirTransportRequest $airTransportRequest): self;
    public function search(int $perPage = 20): Paginator;
    public function create(array $payload): ?AirTransportRequest;
    public function update(array $payload): AirTransportRequest;
    public function addPassengers(array $payload);
    public function addFlights(array $payload);
    public function addSignatories(array $payload);
    public function updateStatus(Status $status): AirTransportRequest;
    public function uploadFiles(array $payload): AirTransportRequest;
}
