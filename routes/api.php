<?php

use App\Http\Controllers\Api\v1\ApprovalController;
use App\Http\Controllers\api\v1\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ErrorController;
use App\Http\Controllers\Api\v1\TicketController;
use App\Http\Controllers\Api\v1\FeatureController;
use App\Http\Controllers\api\v1\TIcketConversionController;

Route::prefix('v1')->group(function () {
    require __DIR__ . '/auth.php';

    Route::middleware('auth:sanctum', 'throttle:api')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::middleware('role:admin,it_staff,reporter,team_lead')->group(function () {
            //ticket routes
            Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
            Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

            //error report routes
            Route::get('/error-reports', [ErrorController::class, 'index'])->name('error-reports.index');
            Route::get('/error-reports/{error}', [ErrorController::class, 'show'])->name('error-reports.show');

            //feature request routes
            Route::get('/feature-requests', [FeatureController::class, 'index'])->name('feature-requests.index');
            Route::get('/feature-requests/{feature}', [FeatureController::class, 'show'])->name('feature-requests.show');

            //comment
            Route::get('/comments', [CommentController::class, 'index']);
            Route::get('/comments/{comment}', [CommentController::class, 'show']);
        });

        Route::middleware('role:it_staff')->group(function () {
            //ticket routes
            Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
            Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
            Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.delete');
            Route::post('/tickets/{ticket}/convert/error-report', [TIcketConversionController::class, 'toErrorReport'])
                ->name('tickets.convert.error-report');
            Route::post('/tickets/{ticket}/convert/feature-request', [TIcketConversionController::class, 'toFeatureRequest'])
                ->name('tickets.convert.error-report');

            //error report routes
            Route::post('/error-reports', [ErrorController::class, 'store'])->name('error-reports.store');
            Route::put('/error-reports/{error}', [ErrorController::class, 'update'])->name('error-reports.update');
            Route::delete('/error-reports/{error}', [ErrorController::class, 'destroy'])->name('error-reports.delete');

            //feature request routes
            Route::post('/feature-requests', [FeatureController::class, 'store'])->name('feature-requests.store');
            Route::put('/feature-requests/{feature}', [FeatureController::class, 'update'])->name('feature-requests.update');
            Route::delete('/feature-requests/{feature}', [FeatureController::class, 'destroy'])->name('feature-requests.delete');
            Route::post('/feature-requests/{feature}/approve', [ApprovalController::class, 'approveFeatureRequest'])
                ->name('feature-requests.approve');

            //comment routes
            Route::post('/comments', [CommentController::class, 'store']);
            Route::put('/comments/{comment}', [CommentController::class, 'update']);
            Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
        });
    });
});
