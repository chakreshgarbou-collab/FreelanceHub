<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFreelancerProfileRequest;
use App\Models\FreelancerProfile;
use Illuminate\Http\Request;

class FreelancerProfileController extends Controller
{
    // PUBLIC: anyone can view a freelancer's profile (read-only)
    public function show(FreelancerProfile $freelancerProfile)
    {
        $freelancerProfile->load('user');

        return view('profiles.freelancer-show', ['profile' => $freelancerProfile]);
    }

    // PRIVATE: show the edit form for the LOGGED-IN user's own profile
    public function edit(Request $request)
    {
        $profile = $request->user()->freelancerProfile;

        return view('profiles.freelancer-edit', ['profile' => $profile]);
    }

    // PRIVATE: save the form (create or update the user's OWN profile only)
    public function update(UpdateFreelancerProfileRequest $request)
    {
        // Profile comes from the logged-in user, NEVER from an ID in the URL
        // (OWASP: broken object-level authorization)
        $request->user()->freelancerProfile()->updateOrCreate([], $request->validated());

        return redirect('/freelancer/profile/edit')->with('success', 'Profile saved successfully.');
    }
}