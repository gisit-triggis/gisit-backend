<?php

namespace App\Http\Controllers\Api\v1\City;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\City\SearchCityRequest;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchCityController extends Controller
{
    protected function handle(): JsonResponse
    {
        $request = app(SearchCityRequest::class)->validated();

        $perPage = $request['first'] ?? 15;
        $page =  $request['page'] ?? 1;

        $cities = City::where('title', 'ILIKE', '%' . $request['query'] . '%')
            ->paginate($perPage, page: $page);

        return fast_response(data: $cities->toArray());
    }
}
