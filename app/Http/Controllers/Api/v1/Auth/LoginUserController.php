<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class LoginUserController extends Controller
{
    public function handle(): JsonResponse
    {
        app(LoginUserRequest::class)->validated();

        $result = DB::transaction(function () {
            $valid_until = getFullDate(now()->addMonth());

            return [
                'token' => createToken(getUser('web'), expiresAt: $valid_until),
                'valid_until' => $valid_until,
            ];
        });

        return fast_response(data: $result);
    }
}
