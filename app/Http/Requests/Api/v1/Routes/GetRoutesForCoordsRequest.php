<?php

namespace App\Http\Requests\Api\v1\Routes;

use Illuminate\Foundation\Http\FormRequest;

class GetRoutesForCoordsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'geojson_geometry' => ['required', 'string', function ($attribute, $value, $fail) {
                json_decode($value);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $fail('The '.$attribute.' must be a valid JSON string.');
                }
            }],
            'num_routes' => ['sometimes', 'integer', 'min:1', 'max:10'],
            'start_point_lon_lat' => ['sometimes', 'array', 'size:2'],
            'start_point_lon_lat.*' => ['required', 'numeric'],
            'end_point_lon_lat' => ['sometimes', 'array', 'size:2'],
            'end_point_lon_lat.*' => ['required', 'numeric'],
        ];
    }
}
