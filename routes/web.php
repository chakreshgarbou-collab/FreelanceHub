<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FreelancerProfileController;
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\FreelancerDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// PUBLIC profiles (no login needed)
Route::get('/freelancers/{freelancerProfile}', [FreelancerProfileController::class, 'show']);
Route::get('/clients/{clientProfile}', [ClientProfileController::class, 'show']);

// PRIVATE pages (only for logged-in users)
Route::middleware('auth')->group(function () {

    // Sends each user to the right dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->freelancerProfile) {
            return redirect('/freelancer/dashboard');
        }
        if ($user->clientProfile) {
            return redirect('/client/profile/edit');
        }
        return redirect('/freelancer/profile/edit');
    });

    Route::get('/freelancer/dashboard', [FreelancerDashboardController::class, 'index']);

    Route::get('/freelancer/profile/edit', [FreelancerProfileController::class, 'edit']);
    Route::put('/freelancer/profile', [FreelancerProfileController::class, 'update']);

    Route::get('/client/profile/edit', [ClientProfileController::class, 'edit']);
    Route::put('/client/profile', [ClientProfileController::class, 'update']);
});

// TEMPORARY - for testing only. DELETE before merging into develop.
if (app()->environment('local')) {
    Route::get('/dev-login/{id}', function ($id) {
        \Illuminate\Support\Facades\Auth::loginUsingId($id);
        return redirect('/dashboard');
    });
}