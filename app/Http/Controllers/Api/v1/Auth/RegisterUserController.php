<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
class RegisterUserController extends Controller
{
    public function handle(): JsonResponse
    {
        $request = app(RegisterUserRequest::class)->validated();

        $result = DB::transaction(function () use ($request) {
            $user = User::create($request);

            $valid_until = getFullDate(now()->addMonth());

            return [
                'token' => createToken($user, expiresAt: $valid_until),
                'valid_until' => $valid_until,
            ];
        });

        return fast_response(data: $result, code: Response::HTTP_CREATED);
    }
}
