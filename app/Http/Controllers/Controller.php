<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class Controller
{
    public function messageResponse(string $message, int $code = Response::HTTP_OK): JsonResponse
    {
        return $this->successResponse($code, [ 'message' => $message ]);
    }

    public function successResponse(int $code, $data = null): JsonResponse
    {
        return response()->json($data, $code);
    }

    public function okResponse($data = null): JsonResponse
    {
        return $this->successResponse(Response::HTTP_OK, $data);
    }

    public function createdResponse($data = null): JsonResponse
    {
        return $this->successResponse(Response::HTTP_CREATED, $data);
    }

    public function errorResponse(int $code, string $message): JsonResponse
    {
        return response()->json([ 'is_error' => true, 'message'  => $message ], $code);
    }

    public function invalidCredentialsResponse(): JsonResponse
    {
        return $this->errorResponse(Response::HTTP_UNAUTHORIZED, 'Credenciais inválidas');
    }

    public function notFoundResponse(string $message = 'Recurso não encontrado'): JsonResponse
    {
        return $this->errorResponse(Response::HTTP_NOT_FOUND, $message);
    }
}
