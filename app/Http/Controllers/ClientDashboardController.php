<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $profile = $user->clientProfile;

        if (! $profile) {
            return redirect('/client/profile/edit');
        }

        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');

        $stats = [
            ['icon' => '📋', 'hint' => 'no activity', 'value' => '0', 'label' => 'Active Orders'],
            ['icon' => '💳', 'hint' => now()->format('M Y'), 'value' => 'Rs 0', 'label' => 'Total Spent'],
            ['icon' => '✅', 'hint' => 'all time', 'value' => '0', 'label' => 'Completed'],
            ['icon' => '⭐', 'hint' => 'to freelancers', 'value' => '0.0 ★', 'label' => 'Avg. Rating Given'],
        ];

        $spend = ['Development' => 0, 'Design' => 0, 'Marketing' => 0];

        return view('dashboards.client', compact('user', 'profile', 'greeting', 'stats', 'spend'));
    }
}