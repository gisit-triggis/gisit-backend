<?php

namespace App\Http\Controllers\Api\v1\Marks;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListMyMarksController extends Controller
{
    protected function handle(): JsonResponse
    {
        $marks = getUser()->marks()->get()->toArray();

        return fast_response(data: $marks);
    }
}
