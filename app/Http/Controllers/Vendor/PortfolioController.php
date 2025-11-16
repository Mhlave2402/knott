<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $profile = Auth::user()->vendorProfile;
        
        if (!$profile) {
            return redirect()->route('vendor.profile.create');
        }

        $portfolio = $profile->portfolio()->paginate(12);
        
        return view('vendor.portfolio.index', compact('portfolio', 'profile'));
    }

    public function create()
    {
        $profile = Auth::user()->vendorProfile;
        
        if (!$profile) {
            return redirect()->route('vendor.profile.create');
        }

        return view('vendor.portfolio.create');
    }

    public function store(Request $request)
    {
        $profile = Auth::user()->vendorProfile;
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'file' => 'required|file|mimes:jpeg,jpg,png,mp4,mov|max:20480',
            'is_featured' => 'boolean',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('vendor-portfolio/' . $profile->id, 'public');
        
        $fileType = in_array($file->getClientOriginalExtension(), ['mp4', 'mov']) ? 'video' : 'image';

        $profile->portfolio()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $filePath,
            'file_type' => $fileType,
            'is_featured' => $validated['is_featured'] ?? false,
            'sort_order' => $profile->portfolio()->count() + 1,
        ]);

        return redirect()->route('vendor.portfolio.index')
                        ->with('success', 'Portfolio item added successfully!');
    }

    public function destroy(VendorPortfolio $portfolio)
    {
        $this->authorize('delete', $portfolio);
        
        Storage::disk('public')->delete($portfolio->file_path);
        $portfolio->delete();

        return redirect()->route('vendor.portfolio.index')
                        ->with('success', 'Portfolio item deleted successfully!');
    }
}