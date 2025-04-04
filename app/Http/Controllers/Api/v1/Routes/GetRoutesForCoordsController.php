<?php

namespace App\Http\Controllers\Api\v1\Routes;

use App\Grpc\Clients\RouteGeneratorClient;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Routes\GetRoutesForCoordsRequest;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use GRPC\RouteGenerator\GenerateRoutesRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spiral\RoadRunner\GRPC\Context;

class GetRoutesForCoordsController extends Controller
{
    public function __construct(
        private RouteGeneratorClient $client
    )
    {
    }

    protected function handle(): JsonResponse
    {
        $request = app(GetRoutesForCoordsRequest::class)->validated();

        $grpcRequest = (new GenerateRoutesRequest())
            ->setGeojsonGeometry($request['geojson_geometry']);

        if (isset($request['num_routes'])) {
            $grpcRequest->setNumRoutes($request['num_routes']);
        }

        if (isset($request['start_point_lon_lat']) && is_array($request['start_point_lon_lat'])) {
            $startPoint = new RepeatedField(GPBType::DOUBLE);
            foreach ($request['start_point_lon_lat'] as $coord) {
                if (is_numeric($coord)) {
                    $startPoint[] = (float)$coord;
                }
            }
            $grpcRequest->setStartPointLonLat($startPoint);
        }

        if (isset($request['end_point_lon_lat']) && is_array($request['end_point_lon_lat'])) {
            $endPoint = new RepeatedField(GPBType::DOUBLE);
            foreach ($request['end_point_lon_lat'] as $coord) {
                if (is_numeric($coord)) {
                    $endPoint[] = (float)$coord;
                }
            }
            $grpcRequest->setEndPointLonLat($endPoint);
        }

        $response = $this->client->GenerateRoutes(
            new Context([]),
            $grpcRequest
        );

        return fast_response(data: $response->getRoutesGeojson());
    }
}
