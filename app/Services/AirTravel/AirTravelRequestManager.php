<?php

namespace App\Services\AirTravel;

use App\Enums\Status;
use App\Models\AirTravelRequest;
use Illuminate\Contracts\Pagination\Paginator;

interface AirTravelRequestManager
{
    public function setAirTravelRequest(AirTravelRequest $airTravelRequest): self;
    public function search(int $perPage = 20): Paginator;
    public function create(array $payload): ?AirTravelRequest;
    public function update(array $payload): AirTravelRequest;
    public function addPassengers(array $payload);
    public function addFlights(array $payload);
    public function addSignatories(array $payload);
    public function updateStatus(Status $status): AirTravelRequest;
}
