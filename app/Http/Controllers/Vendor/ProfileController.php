<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorProfile;
use App\Models\VendorService;
use App\Models\VendorPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Auth::user()->vendorProfile;
        
        if (!$profile) {
            return redirect()->route('vendor.profile.create');
        }

        $stats = [
            'services_count' => $profile->services()->count(),
            'portfolio_count' => $profile->portfolio()->count(),
            'views_count' => 0, // Implement later
            'leads_count' => 0, // Implement later
        ];

        return view('vendor.profile.index', compact('profile', 'stats'));
    }

    public function create()
    {
        if (Auth::user()->vendorProfile) {
            return redirect()->route('vendor.profile.index');
        }

        return view('vendor.profile.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'location' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'service_areas' => 'nullable|array',
            'starting_price' => 'nullable|numeric|min:0',
            'social_media.instagram' => 'nullable|url',
            'social_media.facebook' => 'nullable|url',
        ]);

        Auth::user()->vendorProfile()->create($validated);

        return redirect()->route('vendor.profile.index')
                        ->with('success', 'Profile created successfully! Please complete your services and portfolio.');
    }

    public function edit()
    {
        $profile = Auth::user()->vendorProfile;
        
        if (!$profile) {
            return redirect()->route('vendor.profile.create');
        }

        return view('vendor.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Auth::user()->vendorProfile;
        
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'location' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'service_areas' => 'nullable|array',
            'starting_price' => 'nullable|numeric|min:0',
            'social_media.instagram' => 'nullable|url',
            'social_media.facebook' => 'nullable|url',
        ]);

        $profile->update($validated);

        return redirect()->route('vendor.profile.index')
                        ->with('success', 'Profile updated successfully!');
    }
}