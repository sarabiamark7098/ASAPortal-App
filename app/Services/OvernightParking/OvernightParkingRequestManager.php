<?php

namespace App\Services\OvernightParking;

use App\Enums\Status;
use App\Models\OvernightParkingRequest;
use Illuminate\Contracts\Pagination\Paginator;

interface OvernightParkingRequestManager
{
    public function setOvernightParkingRequest(OvernightParkingRequest $overnightParkingRequest): self;
    public function search(int $perPage = 20): Paginator;
    public function create(array $payload): ?OvernightParkingRequest;
    public function update(array $payload): OvernightParkingRequest;
    public function addSignatories(array $payload);
    public function updateStatus(Status $status): OvernightParkingRequest;
    public function uploadFiles(array $payload): OvernightParkingRequest;
}
