<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ErrorController;
use App\Http\Controllers\Api\v1\TicketController;
use App\Http\Controllers\Api\v1\FeatureController;

Route::prefix('v1')->group(function () {
    require __DIR__ . '/auth.php';

    Route::middleware('auth:sanctum', 'throttle:api')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::middleware('role:admin,it_staff,reporter,team_lead')->group(function () {
            //ticket routes
            Route::get('/tickets', [TicketController::class, 'index']);
            Route::get('/tickets/{ticket}', [TicketController::class, 'show']);

            //error report routes
            Route::get('/error-reports', [ErrorController::class, 'index']);
            Route::get('/error-reports/{error}', [ErrorController::class, 'show']);

            //feature request routes
            Route::get('/feature-requests', [FeatureController::class, 'index']);
            Route::get('/feature-requests/{feature}', [FeatureController::class, 'show']);

            //status history
            Route::get('/status-history', [TicketController::class, 'status']);
        });

        Route::middleware('role:it_staff')->group(function () {
            //ticket routes
            Route::post('/tickets', [TicketController::class, 'store']);
            Route::put('/tickets/{ticket}', [TicketController::class, 'update']);
            Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']);

            //error report routes
            Route::post('/error-reports', [ErrorController::class, 'store']);
            Route::put('/error-reports/{error}', [ErrorController::class, 'update']);
            Route::delete('/error-reports/{error}', [ErrorController::class, 'destroy']);

            //feature request routes
            Route::post('/feature-requests', [FeatureController::class, 'store']);
            Route::put('/feature-requests/{feature}', [FeatureController::class, 'update']);
            Route::delete('/feature-requests/{feature}', [FeatureController::class, 'destroy']);
        });
    });
});
