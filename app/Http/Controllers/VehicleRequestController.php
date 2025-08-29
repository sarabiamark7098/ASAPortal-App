<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\VehicleRequestValidation;
use App\Models\VehicleAssignment;
use App\Models\VehicleRequest;
use App\Services\Pdf\PdfManager;
use App\Services\Vehicle\VehicleRequestManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class VehicleRequestController extends Controller
{
    private VehicleRequestManager $vehicleRequestManager;
    private PdfManager $pdfManager;

    public function __construct(VehicleRequestManager $vehicleRequestManager, PdfManager $pdfManager)
    {
        $this->vehicleRequestManager = $vehicleRequestManager;
        $this->pdfManager = $pdfManager;
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

    public function process(VehicleRequestValidation $request, string|int $id): JsonResponse
    {
        $vehicleRequest = VehicleRequest::findOrFail($id);

        Gate::authorize('process', $vehicleRequest);

        return DB::transaction(function () use ($request, $vehicleRequest) {
            $status = Status::NO_AVAILABLE;
            $vehicleAssignment = VehicleAssignment::find($request->get('vehicle_assignment_id'));
            $isVehicleAvailable = (bool) $request->validated('is_vehicle_available');
            $this->vehicleRequestManager->setVehicleRequest($vehicleRequest);
            $this->vehicleRequestManager->addSignatories($request->validated('signatories'));

            if ($isVehicleAvailable) {
                $this->vehicleRequestManager->assignVehicle($vehicleAssignment);
                $status = Status::PROCESSED;
            }

            $vehicleRequest->fresh()->update([
                'is_vehicle_available' => $isVehicleAvailable,
                'status' => $status
            ]);

            return $this->ok($vehicleRequest->fresh()->toArray());
        });
    }

}
