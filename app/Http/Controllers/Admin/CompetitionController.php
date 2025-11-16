<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\CompetitionEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompetitionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $competitions = Competition::withCount(['entries'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.competitions.index', compact('competitions'));
    }

    public function create()
    {
        return view('admin.competitions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'required|string',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'prize_description' => 'required|string',
            'prize_value' => 'required|numeric|min:0',
            'max_entries' => 'nullable|integer|min:1'
        ]);

        Competition::create($request->all());

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Competition created successfully.');
    }

    public function show(Competition $competition)
    {
        $competition->load(['entries.couple', 'entries.vendors']);
        
        $entries = $competition->entries()
            ->with(['couple', 'vendors', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.competitions.show', compact('competition', 'entries'));
    }

    public function judgeEntry(Request $request, CompetitionEntry $entry)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:10',
            'feedback' => 'nullable|string|max:1000'
        ]);

        $entry->update([
            'admin_score' => $request->score,
            'admin_feedback' => $request->feedback,
            'judged_at' => now(),
            'judged_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Entry judged successfully.');
    }

    public function selectWinner(Request $request, Competition $competition)
    {
        $request->validate([
            'winner_entry_id' => 'required|exists:competition_entries,id'
        ]);

        $competition->update([
            'winner_entry_id' => $request->winner_entry_id,
            'status' => 'completed'
        ]);

        $winnerEntry = CompetitionEntry::find($request->winner_entry_id);
        
        // Send winner notification
        $winnerEntry->couple->notify(new CompetitionWinnerNotification($competition));

        return redirect()->back()->with('success', 'Winner selected successfully.');
    }
}
