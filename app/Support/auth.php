<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

function createToken(User $user, array $privileges = [],  DateTimeInterface|string|null $expiresAt = null)
{
    return $user->createToken($user->id . ':token', [
        'role:user',
        ...$privileges
    ], Carbon::parse($expiresAt) ?? now()->addMonth())->plainTextToken;
}

function getUser(string $guard = 'sanctum'): User
{
    return getCurrentUser($guard) ?? throw new AuthorizationException(__('Unauthorized'));
}

function getCurrentUser(string $guard = 'sanctum'): User|null
{
    return Auth::guard($guard)->user();
}
