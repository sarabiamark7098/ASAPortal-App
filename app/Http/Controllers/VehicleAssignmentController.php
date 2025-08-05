<?php

namespace App\Http\Controllers;

use App\Models\VehicleAssignment;
use Illuminate\Http\JsonResponse;

class VehicleAssignmentController extends Controller
{
    public function index() : JsonResponse {
        $vehicleAssignments = VehicleAssignment::paginate(20);

        return $this->ok($vehicleAssignments->toArray());
    }
}
