<?php

namespace App\Grpc\Controllers;

use GRPC\Auth\AuthInterface;
use GRPC\Auth\AuthorizeByTokenRequest;
use GRPC\Auth\AuthorizeByTokenResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Spiral\RoadRunner\GRPC;

class AuthController implements AuthInterface
{
    public function AuthorizeByToken(GRPC\ContextInterface $ctx, AuthorizeByTokenRequest $in): AuthorizeByTokenResponse
    {
        $token = PersonalAccessToken::where('token','=',$in->getToken())->firstOrFail();

        if ($token && $token->tokenable) {
            Auth::guard('sanctum')->setUser($token->tokenable);
        } else {
            throw new AuthenticationException();
        }

        $user = getUser();

        return (new AuthorizeByTokenResponse())
            ->setAvatarUrl($user->avatar_url)
            ->setEmail($user->email)
            ->setFullName($user->full_name)
            ->setName($user->name)
            ->setSurname($user->surname)
            ->setId($user->id);
    }
}
