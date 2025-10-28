<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\EntryRequestValidation;
use App\Models\EntryRequest;
use App\Services\Entry\EntryRequestManager;
use Illuminate\Http\Request;
use App\Services\Pdf\PdfManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EntryRequestController extends Controller
{
    private EntryRequestManager $entryRequestManager;
    private PdfManager $pdfManager;

    public function __construct(EntryRequestManager $entryRequestManager, PdfManager $pdfManager)
    {
        $this->entryRequestManager = $entryRequestManager;
        $this->pdfManager = $pdfManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $entryRequest = $this->entryRequestManager->search(20);

        return $this->ok($entryRequest->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(EntryRequestValidation $request): JsonResponse
    {
        $entryRequest = $this->entryRequestManager->create([
            ...$request->validated(),
            'user_id' => auth()->user()->id,
        ]);

        $entryRequest = EntryRequest::findOrFail($entryRequest->id);

        Gate::authorize('process', $entryRequest);

        return DB::transaction(function () use ($request, $entryRequest) {
            $this->entryRequestManager->setEntryRequest($entryRequest);
            $this->entryRequestManager->addGuests($request->validated('guests'));
            $this->entryRequestManager->addSignatories($request->validated('signatories'));

            $entryRequest->update(['status' => Status::PROCESSED]);



            return $this->created($entryRequest->fresh()->toArray());
        });
    }


    public function update(EntryRequestValidation $request, string|int $id): JsonResponse
    {
        $entryRequest = EntryRequest::findOrFail($id);

        Gate::authorize('update', $entryRequest);

        $entryRequest->update([
            'status' => Status::from($request->get('status'))
        ]);

        return $this->ok($entryRequest->fresh()->toArray());
    }
}
