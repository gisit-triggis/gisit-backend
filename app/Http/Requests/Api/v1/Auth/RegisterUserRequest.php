<?php

namespace App\Http\Requests\Api\v1\Auth;

use App\Support\AppDefaults;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:' . AppDefaults::passwordMin() . '|max:' . AppDefaults::passwordMax(),
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);
        $validated['password'] = Hash::make($validated['password']);
        return $validated;
    }
}
