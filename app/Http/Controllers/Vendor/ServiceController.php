<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $profile = Auth::user()->vendorProfile;
        
        if (!$profile) {
            return redirect()->route('vendor.profile.create');
        }

        $services = $profile->services()->paginate(10);
        
        return view('vendor.services.index', compact('services', 'profile'));
    }

    public function create()
    {
        $profile = Auth::user()->vendorProfile;
        
        if (!$profile) {
            return redirect()->route('vendor.profile.create');
        }

        $categories = [
            'photography' => 'Photography',
            'videography' => 'Videography', 
            'catering' => 'Catering',
            'venue' => 'Venue',
            'decoration' => 'Decoration & Styling',
            'music' => 'Music & DJ',
            'flowers' => 'Flowers & Bouquets',
            'cake' => 'Wedding Cake',
            'transport' => 'Transport',
            'makeup' => 'Makeup',
            'hair' => 'Hair Styling',
            'other' => 'Other Services'
        ];

        return view('vendor.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $profile = Auth::user()->vendorProfile;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category' => 'required|in:photography,videography,catering,venue,decoration,music,flowers,cake,transport,makeup,hair,other',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|in:fixed,hourly,per_person',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
        ]);

        $profile->services()->create($validated);

        return redirect()->route('vendor.services.index')
                        ->with('success', 'Service added successfully!');
    }

    public function edit(VendorService $service)
    {
        $this->authorize('update', $service);
        
        $categories = [
            'photography' => 'Photography',
            'videography' => 'Videography', 
            'catering' => 'Catering',
            'venue' => 'Venue',
            'decoration' => 'Decoration & Styling',
            'music' => 'Music & DJ',
            'flowers' => 'Flowers & Bouquets',
            'cake' => 'Wedding Cake',
            'transport' => 'Transport',
            'makeup' => 'Makeup',
            'hair' => 'Hair Styling',
            'other' => 'Other Services'
        ];

        return view('vendor.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, VendorService $service)
    {
        $this->authorize('update', $service);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category' => 'required|in:photography,videography,catering,venue,decoration,music,flowers,cake,transport,makeup,hair,other',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|in:fixed,hourly,per_person',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
        ]);

        $service->update($validated);

        return redirect()->route('vendor.services.index')
                        ->with('success', 'Service updated successfully!');
    }

    public function destroy(VendorService $service)
    {
        $this->authorize('delete', $service);
        
        $service->delete();

        return redirect()->route('vendor.services.index')
                        ->with('success', 'Service deleted successfully!');
    }
}