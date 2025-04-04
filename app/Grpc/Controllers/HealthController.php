<?php

namespace App\Grpc\Controllers;

use GRPC\Health\HealthCheckRequest;
use GRPC\Health\HealthCheckResponse;
use GRPC\Health\HealthInterface;
use Spiral\RoadRunner\GRPC;

class HealthController implements HealthInterface
{
    public function Check(GRPC\ContextInterface $ctx, HealthCheckRequest $in): HealthCheckResponse
    {
        return (new HealthCheckResponse())
            ->setStatus(HealthCheckResponse\ServingStatus::SERVING);
    }
}
