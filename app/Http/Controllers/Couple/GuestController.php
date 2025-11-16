<?php
namespace App\Http\Controllers\Couple;

use App\Http\Controllers\Controller;
use App\Models\WeddingGuest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    public function index()
    {
        $profile = Auth::user()->coupleProfile;
        
        if (!$profile) {
            return redirect()->route('couple.profile.create');
        }

        $guests = $profile->guests()->paginate(20);
        
        $stats = [
            'total_guests' => $profile->guests()->sum('plus_one') + $profile->guests()->count(),
            'confirmed' => $profile->guests()->attending()->count(),
            'pending' => $profile->guests()->pending()->count(),
            'declined' => $profile->guests()->declined()->count(),
        ];

        return view('couple.guests.index', compact('profile', 'guests', 'stats'));
    }

    public function create()
    {
        $profile = Auth::user()->coupleProfile;
        
        if (!$profile) {
            return redirect()->route('couple.profile.create');
        }

        return view('couple.guests.create');
    }

    public function store(Request $request)
    {
        $profile = Auth::user()->coupleProfile;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'category' => 'required|in:family,friends,colleagues,other',
            'plus_one' => 'integer|min:0|max:5',
            'dietary_requirements' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        $profile->guests()->create($validated);

        return redirect()->route('couple.guests.index')
                        ->with('success', 'Guest added successfully!');
    }

    public function edit(WeddingGuest $guest)
    {
        $this->authorize('update', $guest);
        
        return view('couple.guests.edit', compact('guest'));
    }

    public function update(Request $request, WeddingGuest $guest)
    {
        $this->authorize('update', $guest);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'category' => 'required|in:family,friends,colleagues,other',
            'rsvp_status' => 'required|in:pending,attending,declined,maybe',
            'plus_one' => 'integer|min:0|max:5',
            'dietary_requirements' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($guest->rsvp_status !== $validated['rsvp_status'] && $validated['rsvp_status'] !== 'pending') {
            $validated['rsvp_date'] = now();
        }

        $guest->update($validated);

        return redirect()->route('couple.guests.index')
                        ->with('success', 'Guest updated successfully!');
    }

    public function destroy(WeddingGuest $guest)
    {
        $this->authorize('delete', $guest);
        
        $guest->delete();

        return redirect()->route('couple.guests.index')
                        ->with('success', 'Guest removed successfully!');
    }

    public function bulkImport(Request $request)
    {
        $profile = Auth::user()->coupleProfile;
        
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->path()));
        $header = array_shift($data);

        $imported = 0;
        foreach ($data as $row) {
            $guestData = array_combine($header, $row);
            
            // Basic validation and mapping
            if (!empty($guestData['name'])) {
                $profile->guests()->create([
                    'name' => $guestData['name'],
                    'email' => $guestData['email'] ?? null,
                    'phone' => $guestData['phone'] ?? null,
                    'category' => in_array($guestData['category'] ?? '', ['family', 'friends', 'colleagues', 'other']) 
                        ? $guestData['category'] : 'friends',
                    'plus_one' => max(0, min(5, intval($guestData['plus_one'] ?? 0))),
                ]);
                $imported++;
            }
        }

        return redirect()->route('couple.guests.index')
                        ->with('success', "Successfully imported {$imported} guests!");
    }
}
