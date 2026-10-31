<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FreelancerProfileController;
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\FreelancerDashboardController;
use App\Http\Controllers\ClientDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/freelancers/{freelancerProfile}', [FreelancerProfileController::class, 'show']);
Route::get('/clients/{clientProfile}', [ClientProfileController::class, 'show']);

Route::middleware(['auth', \App\Http\Middleware\NoIndex::class])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->freelancerProfile) {
            return redirect('/freelancer/dashboard');
        }
        if ($user->clientProfile) {
            return redirect('/client/dashboard');
        }
        return redirect('/freelancer/profile/edit');
    });

    Route::get('/freelancer/dashboard', [FreelancerDashboardController::class, 'index']);
    Route::get('/client/dashboard', [ClientDashboardController::class, 'index']);

    Route::get('/freelancer/profile/edit', [FreelancerProfileController::class, 'edit']);
    Route::put('/freelancer/profile', [FreelancerProfileController::class, 'update']);

    Route::get('/client/profile/edit', [ClientProfileController::class, 'edit']);
    Route::put('/client/profile', [ClientProfileController::class, 'update']);
});
