<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    public function sendSuccessResponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function sendError($errorMessage, $errors = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $errorMessage,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errors;
        }
        return response()->json($response, $code);
    }
}
