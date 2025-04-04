<?php

namespace App\Providers;

use App\Grpc\Clients\RouteGeneratorClient;
use App\Grpc\Controllers\AuthController;
use App\Grpc\Controllers\HealthController;
use GRPC\Auth\AuthInterface;
use GRPC\RouteGenerator\RouteGeneratorInterface;
use Illuminate\Support\ServiceProvider;
use GRPC\Health\HealthInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HealthInterface::class, HealthController::class);
        $this->app->bind(AuthInterface::class, AuthController::class);

        $this->app->bind(RouteGeneratorInterface::class, RouteGeneratorClient::class);
        $this->app->singleton(RouteGeneratorClient::class, static function ($app) {
            return new RouteGeneratorClient(
                config('grpc.route_generator_server'),
                [
                    'grpc.max_receive_message_length' => 10 * 1024 * 1024,
                    'grpc.max_send_message_length' => 10 * 1024 * 1024,
                    'credentials' => null
                ],
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
