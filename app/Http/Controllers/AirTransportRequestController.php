<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\AirTransportRequestValidation;
use App\Models\AirTransportRequest;
use App\Services\AirTransport\AirTransportRequestManager;
use App\Services\Pdf\PdfManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AirTransportRequestController extends Controller
{
    private AirTransportRequestManager $airTransportRequestManager;
    private PdfManager $pdfManager;

    public function __construct(AirTransportRequestManager $airTransportRequestManager, PdfManager $pdfManager)
    {
        $this->airTransportRequestManager = $airTransportRequestManager;
        $this->pdfManager = $pdfManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $airTransportRequests = $this->airTransportRequestManager->search(20);

        return $this->ok($airTransportRequests->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(AirTransportRequestValidation $request): JsonResponse
    {
        $airTransportRequest = $this->airTransportRequestManager->create([
            ...$request->validated(),
            'user_id' => auth()->user()->id,
        ]);

        $airTransportRequest = AirTransportRequest::findOrFail($airTransportRequest->id);

        Gate::authorize('process', $airTransportRequest);

        return DB::transaction(function () use ($request, $airTransportRequest) {

            $this->airTransportRequestManager->setAirTransportRequest($airTransportRequest);
            $this->airTransportRequestManager->addSignatories($request->validated('signatories'));
            $this->airTransportRequestManager->addPassengers($request->validated('passengers'));
            $this->airTransportRequestManager->addFlights($request->validated('flights'));
            $this->airTransportRequestManager->uploadFiles($request->validated('files'));

            $airTransportRequest->update(['status' => Status::PROCESSED]);

            return $this->created($airTransportRequest->fresh()->toArray());
        });

    }

    public function update(AirTransportRequestValidation $request, string|int $id): JsonResponse
    {
        $airTransportRequest = AirTransportRequest::findOrFail($id);

        Gate::authorize('update', $airTransportRequest);

        $airTransportRequest->update([
            'status' => Status::from($request->get('status'))
        ]);

        return $this->ok($airTransportRequest->fresh()->toArray());
    }
}
