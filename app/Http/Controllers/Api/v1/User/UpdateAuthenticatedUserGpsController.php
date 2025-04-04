<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\UpdateAuthenticatedUserGpsRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UpdateAuthenticatedUserGpsController extends Controller
{
    protected function handle(): JsonResponse
    {
        $request = app(UpdateAuthenticatedUserGpsRequest::class)->validated();

        $user = getUser();

        Cache::set('user_gps:' . $user->id, [
            'lat' => $request['latitude'],
            'lon' => $request['longitude'],
            'timestamp' => now(),
        ], 600);

        $latitude = (float) $request['latitude'];
        $longitude = (float) $request['longitude'];
        $timestamp = isset($request['timestamp']) ? Carbon::parse($request['timestamp']) : now();

        app(\ClickHouseDB\Client::class)->insert('user_points', [[
            'user_id' => (int) $user->id,
            'timestamp' => $timestamp->toDateTimeString(),
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]], ['user_id', 'timestamp', 'latitude', 'longitude']);

        return fast_response();
    }
}
