<?php

namespace App\Http\Requests\Api\v1\Marks;

use Illuminate\Foundation\Http\FormRequest;

class DeleteMarkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|exists:marks,id',
        ];
    }
}
