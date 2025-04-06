<?php

namespace App\Http\Requests\Api\v1\AI;

use Illuminate\Foundation\Http\FormRequest;

class AskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'question' => 'required|string',
            'route_id' => 'required|string',
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ];
    }
}
