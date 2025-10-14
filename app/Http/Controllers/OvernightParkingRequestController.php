<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\OvernightParkingRequestValidation;
use App\Models\OvernightParkingRequest;
use App\Services\OvernightParking\OvernightParkingRequestManager;
use App\Services\Pdf\PdfManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OvernightParkingRequestController extends Controller
{
    private OvernightParkingRequestManager $overnightParkingRequestManager;
    private PdfManager $pdfManager;

    public function __construct(OvernightParkingRequestManager $overnightParkingRequestManager, PdfManager $pdfManager)
    {
        $this->overnightParkingRequestManager = $overnightParkingRequestManager;
        $this->pdfManager = $pdfManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $overnightParkingRequests = $this->overnightParkingRequestManager->search(20);

        return $this->ok($overnightParkingRequests->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(OvernightParkingRequestValidation $request): JsonResponse
    {
        $overnightParkingRequest = $this->overnightParkingRequestManager->create([
            ...$request->validated(),
            'user_id' => auth()->user()->id,
        ]);

        return $this->created($overnightParkingRequest->toArray());
    }

    public function process(OvernightParkingRequestValidation $request, string|int $id): JsonResponse
    {
        $overnightParkingRequest = OvernightParkingRequest::findOrFail($id);

        Gate::authorize('process', $overnightParkingRequest);

        return DB::transaction(function () use ($request, $overnightParkingRequest) {
            $status = Status::PROCESSED;
            $this->overnightParkingRequestManager->setOvernightParkingRequest($overnightParkingRequest);
            $this->overnightParkingRequestManager->addSignatories($request->validated('signatories'));

            $overnightParkingRequest->update([
                'status' => $status
            ]);

            return $this->ok($overnightParkingRequest->fresh()->toArray());
        });
    }
    public function update(OvernightParkingRequestValidation $request, string|int $id): JsonResponse
    {
        $overnightParkingRequest = OvernightParkingRequest::findOrFail($id);

        Gate::authorize('update', $overnightParkingRequest);

        $overnightParkingRequest->update([
            'status' => Status::from($request->get('status'))
        ]);

        return $this->ok($overnightParkingRequest->fresh()->toArray());
    }

}
