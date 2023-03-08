<?php

namespace App\Traits;

trait ApiResponse {
    protected function successResponse($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'true',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}