<?php
// FILE: app/Http/Controllers/Couple/DashboardController.php

namespace App\Http\Controllers\Couple;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        $profile = $user->coupleProfile;

        // If the couple has no profile yet, redirect them to create one.
        if (!$profile) {
            return redirect()->route('couple.profile.create')
                ->with('info', 'Please create your profile to get started.');
        }

        $daysUntilWedding = null;
        if ($profile->wedding_date) {
            $daysUntilWedding = round(Carbon::now()->diffInDays($profile->wedding_date, false));
        }

        // Provide default values for all required stats
        $stats = [
            'budget_spent' => 0,
            'budget_remaining' => 0,
            'confirmed_vendors' => 0,
            'guest_count' => 0,
            'days_until_wedding' => $daysUntilWedding,
            'budget_utilization' => 0,
            'total_spent' => 0,
            'total_budget' => 0,
            'confirmed_guests' => 0,
            'pending_rsvp' => 0,
            'completed_todos' => 0,
            'total_todos' => 0,
        ];

        return view('couple.dashboard', compact('profile', 'stats'));
    }
}
