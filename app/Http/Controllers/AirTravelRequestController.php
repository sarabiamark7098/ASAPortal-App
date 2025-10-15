<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\AirTravelRequestValidation;
use App\Models\AirTravelRequest;
use App\Services\AirTravel\AirTravelRequestManager;
use App\Services\Pdf\PdfManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AirTravelRequestController extends Controller
{
    private AirTravelRequestManager $airTravelRequestManager;
    private PdfManager $pdfManager;

    public function __construct(AirTravelRequestManager $airTravelRequestManager, PdfManager $pdfManager)
    {
        $this->airTravelRequestManager = $airTravelRequestManager;
        $this->pdfManager = $pdfManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $airTravelRequests = $this->airTravelRequestManager->search(20);

        return $this->ok($airTravelRequests->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(AirTravelRequestValidation $request): JsonResponse
    {
        $airTravelRequest = $this->airTravelRequestManager->create([
            ...$request->validated(),
            'user_id' => auth()->user()->id,
        ]);

        return $this->created($airTravelRequest->toArray());
    }

    public function process(AirTravelRequestValidation $request, string|int $id): JsonResponse
    {
        $airTravelRequest = AirTravelRequest::findOrFail($id);

        Gate::authorize('process', $airTravelRequest);

        return DB::transaction(function () use ($request, $airTravelRequest) {
            $this->airTravelRequestManager->setAirTravelRequest($airTravelRequest);
            $this->airTravelRequestManager->addSignatories($request->validated('signatories'));

            $status = Status::PROCESSED;

            $airTravelRequest->fresh()->update([
                'status' => $status
            ]);

            return $this->ok($airTravelRequest->fresh()->toArray());
        });
    }
    public function update(AirTravelRequestValidation $request, string|int $id): JsonResponse
    {
        $airTravelRequest = AirTravelRequest::findOrFail($id);

        Gate::authorize('update', $airTravelRequest);

        $airTravelRequest->update([
            'status' => Status::from($request->get('status'))
        ]);

        return $this->ok($airTravelRequest->fresh()->toArray());
    }
}
