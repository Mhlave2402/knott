<?php
namespace App\Http\Controllers\Couple;

use App\Http\Controllers\Controller;
use App\Models\CoupleProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Auth::user()->coupleProfile;
        
        if (!$profile) {
            return redirect()->route('couple.profile.create');
        }

        $stats = [
            'days_until_wedding' => $profile->days_until_wedding,
            'total_budget' => $profile->total_budget,
            'total_spent' => $profile->total_spent,
            'budget_utilization' => $profile->budget_utilization,
            'confirmed_guests' => $profile->confirmed_guests_count,
            'pending_rsvp' => $profile->pending_rsvp_count,
            'completed_todos' => $profile->completed_todos_count,
            'total_todos' => $profile->todos()->count(),
        ];

        return view('couple.dashboard', compact('profile', 'stats'));
    }

    public function create()
    {
        if (Auth::user()->coupleProfile) {
            return redirect()->route('couple.dashboard');
        }

        return view('couple.profile.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'partner_name' => 'nullable|string|max:255',
            'partner_email' => 'nullable|email|max:255',
            'wedding_date' => 'nullable|date|after:today',
            'venue_location' => 'nullable|string|max:255',
            'guest_count' => 'nullable|integer|min:1|max:1000',
            'total_budget' => 'nullable|numeric|min:0',
            'wedding_style' => 'nullable|string|max:255',
            'preferences.colors' => 'nullable|array',
            'preferences.themes' => 'nullable|array',
        ]);

        $profile = Auth::user()->coupleProfile()->create($validated);
        
        // Initialize default budget categories
        $profile->initializeDefaultBudgetCategories();

        return redirect()->route('couple.dashboard')
                        ->with('success', 'Profile created successfully! Start planning your dream wedding.');
    }

    public function edit()
    {
        $profile = Auth::user()->coupleProfile;
        
        if (!$profile) {
            return redirect()->route('couple.profile.create');
        }

        return view('couple.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Auth::user()->coupleProfile;
        
        $validated = $request->validate([
            'partner_name' => 'nullable|string|max:255',
            'partner_email' => 'nullable|email|max:255',
            'wedding_date' => 'nullable|date|after:today',
            'venue_location' => 'nullable|string|max:255',
            'guest_count' => 'nullable|integer|min:1|max:1000',
            'total_budget' => 'nullable|numeric|min:0',
            'wedding_style' => 'nullable|string|max:255',
            'preferences.colors' => 'nullable|array',
            'preferences.themes' => 'nullable|array',
        ]);

        $profile->update($validated);

        return redirect()->route('couple.dashboard')
                        ->with('success', 'Profile updated successfully!');
    }
}