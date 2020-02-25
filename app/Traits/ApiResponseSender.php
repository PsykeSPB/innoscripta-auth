<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponseSender
{
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json($data, $code)->header('Content-Type', 'application/json');
    }

    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    public function errorMessage($message, $code)
    {
        return response()->json($message, $code)->header('Content-Type', 'application/json');
    }
}