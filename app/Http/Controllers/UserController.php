<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    // Require authentication
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

}

