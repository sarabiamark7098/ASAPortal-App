<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignatoryRequest;
use App\Models\Signatory;
use App\Services\Signatory\SignatoryManager;
use Illuminate\Http\JsonResponse;

class SignatoryController extends Controller
{
    public SignatoryManager $signatoryManager;

    public function __construct(SignatoryManager $signatoryManager)
    {
        $this->signatoryManager = $signatoryManager;
    }

    public function index(): JsonResponse
    {
        $signatory = $this->signatoryManager->search(20);
        return response()->json($signatory);
    }
    public function fetch(): JsonResponse
    {
        return $this->ok(Signatory::all()->toArray());
    }
    public function get(SignatoryRequest $request)
    {
        $search = $request->get('request'); // get ?request=Regional Director
        $signatory = Signatory::where('position', 'like', '%' . $search . '%')->first();

        return response()->json($signatory);
    }

    public function store(SignatoryRequest $request): JsonResponse
    {
        $signatory = Signatory::create($request->validated());
        return response()->json($signatory, 201);
    }

    public function update(SignatoryRequest $request, $id): JsonResponse
    {
        $signatory = Signatory::findOrFail($id);
        $signatory->update($request->validated());
        return response()->json($signatory);
    }

}
