<?php

namespace App\Http\Controllers;

use App\Models\Signatory;
use Illuminate\Http\JsonResponse;

class SignatoryController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->ok(Signatory::all()->toArray());
    }
}
