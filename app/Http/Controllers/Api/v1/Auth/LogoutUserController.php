<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutUserController extends Controller
{
    public function handle(): JsonResponse
    {
        $user = getUser();

        $user->currentAccessToken()->delete();

        return fast_response();
    }
}
