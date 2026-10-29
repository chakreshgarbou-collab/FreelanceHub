<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFreelancerProfileRequest;
use Illuminate\Http\Request;

class FreelancerProfileController extends Controller
{
    // Show the edit form for the LOGGED-IN user's own profile
    public function edit(Request $request)
    {
        $profile = $request->user()->freelancerProfile;   // null if they don't have one yet

        return view('profiles.freelancer-edit', ['profile' => $profile]);
    }

    // Save the form (creates the profile if it doesn't exist, updates it if it does)
    public function update(UpdateFreelancerProfileRequest $request)
    {
        // Profile comes from the logged-in user, NEVER from an ID in the URL,
        // so nobody can edit someone else's profile (OWASP: broken object-level authorization)
        $request->user()->freelancerProfile()->updateOrCreate([], $request->validated());

        return redirect('/freelancer/profile/edit')->with('success', 'Profile saved successfully.');
    }
}