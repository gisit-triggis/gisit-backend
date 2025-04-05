<?php

namespace App\Grpc\Clients;

use App\Traits\GrpcTrait;
use Grpc\BaseStub;
use GRPC\Position\GetAllPositionsRequest;
use GRPC\Position\GetAllPositionsResponse;
use GRPC\Position\PositionResponse;
use GRPC\Position\PositionServiceInterface;
use GRPC\Position\PositionUpdate;
use Spiral\RoadRunner\GRPC;

class PositionClient extends BaseStub implements PositionServiceInterface
{
    use GrpcTrait;

    public function UpdatePosition(GRPC\ContextInterface $ctx, PositionUpdate $in): PositionResponse
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/UpdatePosition',
            $in,
            [PositionResponse::class, 'decode'],
            (array) $ctx->getValue('metadata'),
            (array) $ctx->getValue('options'),
        )->wait();

        $this->handleErrors($status);

        return $response;
    }

    public function StreamPositionUpdates(GRPC\ContextInterface $ctx, PositionUpdate $in): PositionResponse
    {
        return (new PositionResponse())->setSuccess(false)->setMessage('Its not implemented yet');
    }

    public function GetAllPositions(GRPC\ContextInterface $ctx, GetAllPositionsRequest $in): GetAllPositionsResponse
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/GetAllPositions',
            $in,
            [GetAllPositionsResponse::class, 'decode'],
            (array) $ctx->getValue('metadata'),
            (array) $ctx->getValue('options'),
        )->wait();

        $this->handleErrors($status);

        return $response;
    }
}
