<?php

namespace App\Http\Controllers\Api\v1\Routes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListPredefinedRoutesController extends Controller
{
    protected function handle(): JsonResponse
    {
        $routes = Storage::disk('public')->get('roads.geojson');

        return fast_response(data: $routes);
    }
}
