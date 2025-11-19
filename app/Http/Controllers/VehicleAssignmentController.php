<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleAssignmentRequest;
use App\Models\VehicleAssignment;
use Illuminate\Http\JsonResponse;

class VehicleAssignmentController extends Controller
{
    public function index(): JsonResponse
    {
        $vehicleAssignments = VehicleAssignment::paginate(20);

        return $this->ok($vehicleAssignments->toArray());
    }

    public function fetch(VehicleAssignment $vehicleAssignment): JsonResponse
    {
        return response()->json($vehicleAssignment);
    }

    public function store(VehicleAssignmentRequest $request): JsonResponse
    {
        $vehicleAssignment = VehicleAssignment::create($request->validated());

        return response()->json($vehicleAssignment, 201);
    }
    public function update(VehicleAssignmentRequest $request, $id): JsonResponse
    {
        $vehicleAssignment = VehicleAssignment::where('vehicle_id', $id)->latest()->first();

        $vehicleAssignment->update($request->validated());

        return response()->json($vehicleAssignment);
    }


}
