<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\JsonResponse;

class TransactionsController extends Controller
{
    public function fetch(): JsonResponse
    {
        return $this->ok(Transaction::all()->toArray());
    }
}
