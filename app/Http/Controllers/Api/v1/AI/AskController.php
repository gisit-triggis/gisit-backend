<?php

namespace App\Http\Controllers\Api\v1\AI;

use App\Grpc\Clients\RouteGeneratorClient;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\AI\AskRequest;
use GRPC\RouteGenerator\AssistantRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spiral\RoadRunner\GRPC\Context;

class AskController extends Controller
{

    public function __construct(
        private RouteGeneratorClient $client
    )
    {
    }

    protected function handle(): JsonResponse
    {
        $request = app(AskRequest::class )->validated();

        $grpcRequest = (new AssistantRequest())
            ->setQuestion($request["question"])
            ->setRouteId($request["route_id"])
            ->setCurrentLocationLonLat([$request['longitude'], $request['latitude']]);

        $response = $this->client->AskAssistant(
            new Context([]),
            $grpcRequest
        );

        $data = [
            'answer' => $response->getAnswer(),
            'recommended' => $response->getRecommendedActions(),
            'level' => $response->getWarningLevel()
        ];

        return fast_response(data: $data);
    }
}
