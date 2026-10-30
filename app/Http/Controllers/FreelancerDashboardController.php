<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FreelancerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $profile = $user->freelancerProfile;

        if (! $profile) {
            return redirect('/freelancer/profile/edit');
        }

        $skills = array_values(array_filter(array_map('trim', explode(',', $profile->skills ?? ''))));

        $checks = [
            'Professional title' => filled($profile->professional_title),
            'Bio written' => filled($profile->bio),
            'Skills (' . count($skills) . ' added)' => count($skills) > 0,
            'Location' => filled($profile->location),
            'Hourly rate set' => $profile->hourly_rate > 0,
        ];

        $strength = (int) round(collect($checks)->filter()->count() / 5 * 100);

        $stats = [
            ['label' => 'This Month', 'value' => 'Rs 0', 'note' => 'no earnings yet'],
            ['label' => 'Pending Payout', 'value' => 'Rs 0', 'note' => '0 gigs in progress'],
            ['label' => 'Profile Views', 'value' => '0', 'note' => 'no views this week'],
            ['label' => 'Avg. Rating', 'value' => '0.0 ★', 'note' => 'no reviews yet'],
        ];

        return view('dashboards.freelancer', compact('user', 'profile', 'skills', 'checks', 'strength', 'stats'));
    }
}