<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\UpdateAuthenticatedUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateAuthenticatedUserController extends Controller
{
    protected function handle(): JsonResponse
    {
        $request = app(UpdateAuthenticatedUserRequest::class)->validated();

        getUser()->update($request);

        return fast_response(data: $request);
    }
}
