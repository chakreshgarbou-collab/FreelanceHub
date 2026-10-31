<?php

use App\Models\Service;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FreelancerProfileController;
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\FreelancerDashboardController;
use App\Http\Controllers\ClientDashboardController;

// PUBLIC ROUTES

// Homepage.
Route::get('/', function () {
    return view('welcome');
});

// Public freelancer profile.
Route::get('/freelancers/{freelancerProfile}', [
    FreelancerProfileController::class,
    'show'
]);

// Public client profile.
Route::get('/clients/{clientProfile}', [
    ClientProfileController::class,
    'show'
]);

// Public Service Catalogue.
// Visitors and clients can browse services without login.
Route::view('/services', 'services.catalogue')
    ->name('services.catalogue');


// AUTHENTICATED ROUTES

Route::middleware([
    'auth',
    \App\Http\Middleware\NoIndex::class
])->group(function () {

    // DASHBOARD ROUTES

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

    Route::get('/freelancer/dashboard', [
        FreelancerDashboardController::class,
        'index'
    ]);

    Route::get('/client/dashboard', [
        ClientDashboardController::class,
        'index'
    ]);


    // FREELANCER PROFILE ROUTES

    Route::get('/freelancer/profile/edit', [
        FreelancerProfileController::class,
        'edit'
    ]);

    Route::put('/freelancer/profile', [
        FreelancerProfileController::class,
        'update'
    ]);


    // CLIENT PROFILE ROUTES

    Route::get('/client/profile/edit', [
        ClientProfileController::class,
        'edit'
    ]);

    Route::put('/client/profile', [
        ClientProfileController::class,
        'update'
    ]);


    // SERVICE CATALOGUE MANAGEMENT

    // Open the create service form.
    // Only authenticated users with a freelancer profile can access it.
    Route::get('/services/create', function () {

        $user = auth()->user();

        abort_unless($user->freelancerProfile, 403);

        return view('services.form');

    })->name('services.create');


    // Open the edit service form.
    // ServicePolicy checks whether the logged-in user owns the service.
    Route::get('/services/{service}/edit', function (Service $service) {

        Gate::authorize('update', $service);

        return view('services.form', [
            'service' => $service
        ]);

    })->name('services.edit');

});