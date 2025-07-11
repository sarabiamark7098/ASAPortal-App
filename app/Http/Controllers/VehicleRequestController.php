<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequestValidation;
use App\Models\VehicleRequest;
use App\Services\VehicleRequestManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class VehicleRequestController extends Controller
{
    private VehicleRequestManager $vehicleRequestManager;

    public function __construct(VehicleRequestManager $vehicleRequestManager)
    {
        $this->vehicleRequestManager = $vehicleRequestManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vehicleRequests = $this->vehicleRequestManager->paginated([]);
        return $this->ok($vehicleRequests->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(VehicleRequestValidation $request): JsonResponse
    {
        $vehicleRequest = $this->vehicleRequestManager->create([
            ...$request->validated(),
            'user_id' => auth()->user()->id,
        ]);

        return $this->created($vehicleRequest->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleRequest $vehicleRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleRequest $vehicleRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleRequest $vehicleRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleRequest $vehicleRequest)
    {
        //
    }
}
