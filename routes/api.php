<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;

// Public routes: visitors can browse the catalogue.
Route::get('/services', [ServiceController::class, 'index']);

Route::get('/categories', [CategoryController::class, 'index']);

// Protected routes: freelancers must be authenticated.
// These use Sanctum only if your team has installed and configured it.
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/services', [ServiceController::class, 'store']);

    Route::put('/services/{service}', [ServiceController::class, 'update']);

    Route::patch(
        '/services/{service}/deactivate',
        [ServiceController::class, 'deactivate']
    );

});