<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\ConferenceRequestValidation;
use App\Models\ConferenceRequest;
use App\Services\Conference\ConferenceRequestManager;
use App\Services\Pdf\PdfManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ConferenceRequestController extends Controller
{

    private ConferenceRequestManager $conferenceRequestManager;
    private PdfManager $pdfManager;

    public function __construct(ConferenceRequestManager $conferenceRequestManager, PdfManager $pdfManager)
    {
        $this->conferenceRequestManager = $conferenceRequestManager;
        $this->pdfManager = $pdfManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $conferenceRequests = $this->conferenceRequestManager->search(20);

        return $this->ok($conferenceRequests->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(ConferenceRequestValidation $request): JsonResponse
    {
        $conferenceRequest = $this->conferenceRequestManager->create([
            ...$request->validated(),
            'user_id' => auth()->user()->id,
        ]);

        $conferenceRequest = ConferenceRequest::findOrFail($conferenceRequest->id);
        return DB::transaction(function () use ($request, $conferenceRequest) {
            $this->conferenceRequestManager->setConferenceRequest($conferenceRequest);
            $this->conferenceRequestManager->uploadFiles($request->validated('files'));

            return $this->created($conferenceRequest->fresh()->toArray());
        });

    }

    public function process(ConferenceRequestValidation $request, string|int $id): JsonResponse
    {
        $conferenceRequest = ConferenceRequest::findOrFail($id);

        Gate::authorize('process', $conferenceRequest);

        return DB::transaction(function () use ($request, $conferenceRequest) {
            $status = Status::NO_AVAILABLE;
            $isConferenceAvailable = (bool) $request->validated('is_conference_available');
            $this->conferenceRequestManager->setConferenceRequest($conferenceRequest);
            $this->conferenceRequestManager->addSignatories($request->validated('signatories'));

            if($isConferenceAvailable) {
                $status = Status::PROCESSED;
            }

            $conferenceRequest->fresh()->update([
                'is_conference_available' => $isConferenceAvailable,
                'status' => $status
            ]);

            return $this->ok($conferenceRequest->fresh()->toArray());
        });
    }
    public function update(ConferenceRequestValidation $request, string|int $id): JsonResponse
    {
        $conferenceRequest = ConferenceRequest::findOrFail($id);

        Gate::authorize('update', $conferenceRequest);

        $conferenceRequest->update([
            'status' => Status::from($request->get('status'))
        ]);

        return $this->ok($conferenceRequest->fresh()->toArray());
    }

}
