<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use App\Services\Vehicle\VehicleManager;
use Illuminate\Http\Request;
use App\Enums\VehicleUnitType;

class VehicleController extends Controller
{
    public VehicleManager $vehicleManager;

    public function __construct(VehicleManager $vehicleManager)
    {
        $this->vehicleManager = $vehicleManager;
    }

    public function index(Request $request)
    {
        $vehicles = $this->vehicleManager->search(20);
        return response()->json($vehicles);
    }

    public function type()
    {
        return response()->json(VehicleUnitType::asLabel());
    }

    public function fetch()
    {
        $vehicles = Vehicle::all();
        return response()->json($vehicles);
    }

    public function store(VehicleRequest $request) {
        $vehicle = Vehicle::create($request->validated());
        return response()->json($vehicle, 201);
    }

    public function update(VehicleRequest $request, $id) {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->validated());
        return response()->json($vehicle);
    }

}
