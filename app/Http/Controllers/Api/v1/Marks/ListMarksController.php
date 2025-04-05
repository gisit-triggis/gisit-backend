<?php

namespace App\Http\Controllers\Api\v1\Marks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Marks\ListMarksRequest;
use App\Models\Mark;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListMarksController extends Controller
{
    protected function handle(): JsonResponse
    {
        $marks = Mark::get();

        return fast_response(data: $marks->toArray());
    }
}
