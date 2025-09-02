<?php

namespace App\Services\Driver;

use App\Models\Driver;
use Illuminate\Contracts\Pagination\Paginator;

interface DriverManager
{
    public function search(int $perPage = 20): Paginator;
}
