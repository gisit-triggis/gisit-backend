<?php

namespace App\Http\Requests\Api\v1\Auth;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoginUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|max:255',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        if (!Auth::attempt($validated)) {
            throw new AuthenticationException(__('Invalid email or password'));
        }

        return $validated;
    }
}
