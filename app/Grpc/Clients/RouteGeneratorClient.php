<?php

namespace App\Grpc\Clients;

use App\Traits\GrpcTrait;
use Grpc\BaseStub;
use GRPC\RouteGenerator\GenerateRoutesRequest;
use GRPC\RouteGenerator\GenerateRoutesResponse;
use GRPC\RouteGenerator\RouteGeneratorInterface;
use Spiral\RoadRunner\GRPC;

class RouteGeneratorClient extends BaseStub implements RouteGeneratorInterface
{
    use GrpcTrait;

    public function GenerateRoutes(GRPC\ContextInterface $ctx, GenerateRoutesRequest $in): GenerateRoutesResponse
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/GenerateRoutes',
            $in,
            [GenerateRoutesResponse::class, 'decode'],
            (array) $ctx->getValue('metadata'),
            (array) $ctx->getValue('options'),
        )->wait();

        $this->handleErrors($status);

        return $response;
    }
}
