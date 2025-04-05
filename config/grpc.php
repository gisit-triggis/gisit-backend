<?php
return [
    'route_generator_server' => env('GRPC_ROUTE_GENERATOR_SERVER', 'ai-backend:9090'),
    'position_server' => env('GRPC_POSITION_SERVER', 'realtime-backend:9090'),
];
