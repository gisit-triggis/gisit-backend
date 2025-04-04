<?php

use App\Grpc\Contracts\KernelContract;
use App\Grpc\Contracts\ServiceInvoker;
use App\Grpc\Kernel as GrpcKernel;
use App\Grpc\LaravelServiceInvoker;
use GRPC\Auth\AuthInterface;
use GRPC\Health\HealthInterface;
use Spiral\RoadRunner\GRPC\Invoker;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';


$app->singleton(
    KernelContract::class,
    GrpcKernel::class
);

$app->singleton(
    ServiceInvoker::class,
    LaravelServiceInvoker::class
);

$kernel = $app->make(GrpcKernel::class);

$server = new Server(new Invoker(), [
    'debug' => env('GRPC_DEBUG', true),
]);

$kernel->registerService(HealthInterface::class);
$kernel->registerService(AuthInterface::class);

$kernel->serve(Worker::create());
