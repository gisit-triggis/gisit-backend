<?php

use App\Http\Controllers\Api\v1\Auth\LoginUserController;
use App\Http\Controllers\Api\v1\Auth\LogoutUserController;
use App\Http\Controllers\Api\v1\Auth\RegisterUserController;
use App\Http\Controllers\Api\v1\Routes\GetRoutesForCoordsController;
use App\Http\Controllers\Api\v1\Storage\PutFileIntoStorageController;
use App\Http\Controllers\Api\v1\User\GetAuthenticatedUserController;
use App\Http\Controllers\Api\v1\User\UpdateAuthenticatedUserController;
use App\Http\Controllers\Api\v1\User\UpdateAuthenticatedUserGpsController;
use Illuminate\Support\Facades\Route;


Route::prefix('/v1')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/login', LoginUserController::class);
        Route::post('/register', RegisterUserController::class);
        Route::post('/logout', LogoutUserController::class);
    });
    Route::prefix('/user')->group(function () {
        Route::get('/me', GetAuthenticatedUserController::class);
        Route::patch('/me', UpdateAuthenticatedUserController::class);
        Route::patch('/gps', UpdateAuthenticatedUserGpsController::class);
        Route::get('/paths'); // TODO: Получение всех своих путей

        Route::prefix('/routes')->group(function () {
            Route::post('/get', GetRoutesForCoordsController::class); // TODO: Получение картинки визуализации
        });

        Route::post('/storage', PutFileIntoStorageController::class);
    })->middleware(['auth:sanctum']);
});
