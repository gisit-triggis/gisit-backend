<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\User\AuthenticatedUserResource;
use Illuminate\Http\JsonResponse;

class GetAuthenticatedUserController extends Controller
{
    public function handle(): JsonResponse
    {
        return fast_response(data: AuthenticatedUserResource::make(getUser()));
    }
}
