<?php

namespace App\Http\Controllers\Api\v1\Marks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Marks\DeleteMarkRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteMarkController extends Controller
{
    protected function handle(): JsonResponse
    {
        $request = app(DeleteMarkRequest::class)->validated();

        getUser()->marks()->findOrFail($request['id'])->delete();

        return fast_response();
    }
}
