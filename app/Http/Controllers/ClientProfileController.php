<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateClientProfileRequest;
use App\Models\ClientProfile;
use Illuminate\Http\Request;

class ClientProfileController extends Controller
{
    // PUBLIC: anyone can view a client's profile (address is NOT shown)
    public function show(ClientProfile $clientProfile)
    {
        $clientProfile->load('user');

        return view('profiles.client-show', ['profile' => $clientProfile]);
    }

    // PRIVATE: edit form for the LOGGED-IN user's own client profile
    public function edit(Request $request)
    {
        $profile = $request->user()->clientProfile;

        return view('profiles.client-edit', ['profile' => $profile]);
    }

    // PRIVATE: save the form (create or update the user's OWN profile only)
    public function update(UpdateClientProfileRequest $request)
    {
        // Profile comes from the logged-in user, NEVER from an ID in the URL
        $request->user()->clientProfile()->updateOrCreate([], $request->validated());

        return redirect('/client/profile/edit')->with('success', 'Profile saved successfully.');
    }
}