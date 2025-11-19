<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle;
use Illuminate\Contracts\Pagination\Paginator;

interface VehicleManager
{
    public function search(int $perPage = 20): Paginator;
}
