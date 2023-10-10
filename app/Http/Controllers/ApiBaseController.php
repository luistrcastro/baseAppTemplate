<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class ApiBaseController extends Controller
{
    public function sendSuccess($data, $message, $code = 200): JsonResponse
    {
        return Response::json(ResponseUtil::makeResponse(true, $message, $data), $code);
    }

    public function sendError($message, $code = 404): JsonResponse
    {
        return Response::json(ResponseUtil::makeResponse(false, $message), $code);
    }
}
