<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class Controller
{
    public function ok(array $data = []): JsonResponse
    {
        return response()->json($data, Response::HTTP_OK);
    }

    public function created(array $data = []): JsonResponse
    {
        return response()->json($data, Response::HTTP_CREATED);
    }

    public function error(array $data = [], Response $errorCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json($data, $errorCode);
    }
}
