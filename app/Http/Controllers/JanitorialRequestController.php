<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\JanitorialRequestValidation;
use App\Models\JanitorialRequest;
use App\Services\Janitorial\JanitorialRequestManager;
use App\Services\Pdf\PdfManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class JanitorialRequestController extends Controller
{
    private JanitorialRequestManager $janitorialRequestManager;
    private PdfManager $pdfManager;

    public function __construct(JanitorialRequestManager $janitorialRequestManager, PdfManager $pdfManager)
    {
        $this->janitorialRequestManager = $janitorialRequestManager;
        $this->pdfManager = $pdfManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $janitorialRequest = $this->janitorialRequestManager->search(20);

        return $this->ok($janitorialRequest->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(JanitorialRequestValidation $request): JsonResponse
    {
        $janitorialRequest = $this->janitorialRequestManager->create([
            ...$request->validated(),
            'user_id' => auth()->user()->id,
        ]);

        $janitorialRequest = JanitorialRequest::findOrFail($janitorialRequest->id);
        return DB::transaction(function () use ($request, $janitorialRequest) {
            $this->janitorialRequestManager->setJanitorialRequest($janitorialRequest);
            $this->janitorialRequestManager->uploadFiles($request->validated('files'));

            return $this->created($janitorialRequest->fresh()->toArray());
        });
    }

    public function process(JanitorialRequestValidation $request, string|int $id): JsonResponse
    {
        $janitorialRequest = JanitorialRequest::findOrFail($id);

        Gate::authorize('process', $janitorialRequest);

        return DB::transaction(function () use ($request, $janitorialRequest) {
            $status = Status::PROCESSED;
            $this->janitorialRequestManager->setJanitorialRequest($janitorialRequest);
            $this->janitorialRequestManager->addSignatories($request->validated('signatories'));
            $this->janitorialRequestManager->addJanitors($request->validated('janitors'));

            $janitorialRequest->update([
                'status' => $status
            ]);

            return $this->ok($janitorialRequest->fresh()->toArray());
        });
    }
    public function update(JanitorialRequestValidation $request, string|int $id): JsonResponse
    {
        $janitorialRequest = JanitorialRequest::findOrFail($id);

        Gate::authorize('update', $janitorialRequest);

        $janitorialRequest->update([
            'status' => Status::from($request->get('status'))
        ]);

        return $this->ok($janitorialRequest->fresh()->toArray());
    }
}
