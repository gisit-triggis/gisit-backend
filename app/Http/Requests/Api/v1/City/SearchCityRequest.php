<?php

namespace App\Http\Requests\Api\v1\City;

use Illuminate\Foundation\Http\FormRequest;

class SearchCityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'query' => 'string|nullable|max:255',
            'first' => 'integer|nullable|min:1|max:50',
            'page' => 'integer|nullable|min:1',
        ];
    }
}
