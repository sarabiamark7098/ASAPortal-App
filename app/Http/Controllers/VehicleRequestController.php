<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequestValidation;
use App\Models\VehicleAssignment;
use App\Models\VehicleRequest;
use App\Services\VehicleRequestManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
    public function index(Request $request): JsonResponse
    {
        $vehicleRequests = $this->vehicleRequestManager->search();

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

    public function process(VehicleRequestValidation $request, int|string $id): JsonResponse
    {
        $vehicleRequest = VehicleRequest::findOrFail($id);

        Gate::authorize('process', $vehicleRequest);

        return DB::transaction(function() use ($request, $vehicleRequest) {
            $vehicleAssignment = VehicleAssignment::find($request->get('vehicle_assignment_id'));
            
            $this->vehicleRequestManager->addSignatories($vehicleRequest, $request->validated('signatories'));
            $vehicleRequest = $this->vehicleRequestManager->process($vehicleRequest, $vehicleAssignment);

            return $this->ok($vehicleRequest->toArray());
        });
    }
}
