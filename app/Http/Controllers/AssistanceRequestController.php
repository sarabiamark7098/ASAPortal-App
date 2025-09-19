<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\AssistanceRequestValidation;
use App\Models\AssistanceRequest;
use App\Services\Assistance\AssistanceRequestManager;
use App\Services\Pdf\PdfManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AssistanceRequestController extends Controller
{
    private AssistanceRequestManager $assistanceRequestManager;
    private PdfManager $pdfManager;

    public function __construct(AssistanceRequestManager $assistanceRequestManager, PdfManager $pdfManager)
    {
        $this->assistanceRequestManager = $assistanceRequestManager;
        $this->pdfManager = $pdfManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $assistanceRequest = $this->assistanceRequestManager->search(20);

        return $this->ok($assistanceRequest->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(AssistanceRequestValidation $request): JsonResponse
    {
        $assistanceRequest = $this->assistanceRequestManager->create([
            ...$request->validated(),
            'user_id' => auth()->user()->id,
        ]);

        return $this->created($assistanceRequest->toArray());
    }

    public function process(AssistanceRequestValidation $request, string|int $id): JsonResponse
    {
        $assistanceRequest = AssistanceRequest::findOrFail($id);

        Gate::authorize('process', $assistanceRequest);

        return DB::transaction(function () use ($request, $assistanceRequest) {
            $this->assistanceRequestManager->setAssistanceRequest($assistanceRequest);
            $this->assistanceRequestManager->addSignatories($request->validated('signatories'));

            $assistanceRequest->update([
                'status' => Status::from($request->get('status'))
            ]);

            return $this->ok($assistanceRequest->fresh()->toArray());
        });
    }

}
