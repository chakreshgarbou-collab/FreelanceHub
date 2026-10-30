<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FreelancerProfileController;

Route::get('/', function () {
    return view('welcome');
});

// PUBLIC freelancer profile (no login needed)
Route::get('/freelancers/{freelancerProfile}', [FreelancerProfileController::class, 'show']);

// PRIVATE profile pages (only for logged-in users)
Route::middleware('auth')->group(function () {
    Route::get('/freelancer/profile/edit', [FreelancerProfileController::class, 'edit']);
    Route::put('/freelancer/profile', [FreelancerProfileController::class, 'update']);
});

// TEMPORARY - for testing only. DELETE before merging into develop.
if (app()->environment('local')) {
    Route::get('/dev-login/{id}', function ($id) {
        \Illuminate\Support\Facades\Auth::loginUsingId($id);
        return redirect('/freelancer/profile/edit');
    });
}