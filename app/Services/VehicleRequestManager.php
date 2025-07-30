<?php

namespace App\Services;

use App\Models\VehicleRequest;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface VehicleRequestManager {
    public function fetch() : Collection;
    public function search(int $perPage = 20) : Paginator;
    public function create(array $payload) : ?VehicleRequest;
}