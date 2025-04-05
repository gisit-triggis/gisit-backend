<?php

namespace App\Http\Controllers\Api\v1\Marks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Marks\CreateMarkRequest;
use App\Models\Mark;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateMarkController extends Controller
{
    protected function handle(): JsonResponse
    {
        $request = app(CreateMarkRequest::class)->validated();

        $request['geometry'] = Point::make($request['longitude'], $request['latitude']);
        $request['user_id'] = getUser()->id;

        $mark = Mark::create($request);

        return fast_response(data: $mark->toArray());
    }
}
