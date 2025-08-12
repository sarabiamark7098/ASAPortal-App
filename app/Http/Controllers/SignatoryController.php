<?php

namespace App\Http\Controllers;

use App\Models\Signatory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SignatoryController extends Controller
{
    public function index() : JsonResponse {
        return $this->ok(Signatory::all()->toArray());
    }
}
