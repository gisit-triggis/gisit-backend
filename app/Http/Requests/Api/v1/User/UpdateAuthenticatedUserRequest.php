<?php

namespace App\Http\Requests\Api\v1\User;

use App\Support\AppDefaults;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthenticatedUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|min:'. AppDefaults::userNameMin() .'|max:' . AppDefaults::userNameMax(),
            'surname' => 'nullable|string|min:' . AppDefaults::userSurnameMin() . '|max:' . AppDefaults::userSurnameMax(),
            'avatar_url' => 'nullable|string|url|starts_with:https://s3.gisit-triggis-hackathon.ru/',
        ];
    }
}
