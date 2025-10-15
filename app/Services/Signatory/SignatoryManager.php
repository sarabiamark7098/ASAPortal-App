<?php

namespace App\Services\Signatory;

use App\Models\Signatory;
use Illuminate\Contracts\Pagination\Paginator;

interface SignatoryManager
{
    public function search(int $perPage = 20): Paginator;
}
