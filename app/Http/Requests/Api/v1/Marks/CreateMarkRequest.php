<?php

namespace App\Http\Requests\Api\v1\Marks;

use App\Models\Mark;
use App\Support\AppDefaults;
use Illuminate\Foundation\Http\FormRequest;

class CreateMarkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => 'string|required|min:3',
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'type' => 'required|in:' . implode(',', AppDefaults::markTypes()),
        ];
    }
}
