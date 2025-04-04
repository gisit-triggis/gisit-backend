<?php

namespace App\Http\Requests\Api\v1\Storage;

use Illuminate\Foundation\Http\FormRequest;

class PutFileIntoStorageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ];
    }
}
