<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\DisputeMessage;
use App\Notifications\DisputeStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisputeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $disputes = Dispute::with(['booking', 'complainant', 'respondent', 'assignedAdmin'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->priority, function ($query, $priority) {
                return $query->where('priority', $priority);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('subject', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderByRaw("CASE WHEN status = 'open' THEN 1 ELSE 2 END")
            ->orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 ELSE 3 END")
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.disputes.index', compact('disputes'));
    }

    public function show(Dispute $dispute)
    {
        $dispute->load(['messages.user', 'booking.vendor', 'booking.couple']);
        
        return view('admin.disputes.show', compact('dispute'));
    }

    public function assign(Request $request, Dispute $dispute)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id'
        ]);

        $dispute->update([
            'assigned_to' => $request->admin_id,
            'status' => 'in_progress'
        ]);

        return redirect()->back()->with('success', 'Dispute assigned successfully.');
    }

    public function addMessage(Request $request, Dispute $dispute)
    {
        $request->validate([
            'message' => 'required|string|max:2000'
        ]);

        DisputeMessage::create([
            'dispute_id' => $dispute->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'is_internal' => $request->boolean('internal_note')
        ]);

        // Notify relevant parties
        if (!$request->boolean('internal_note')) {
            $dispute->complainant->notify(new DisputeStatusUpdated($dispute));
            $dispute->respondent->notify(new DisputeStatusUpdated($dispute));
        }

        return redirect()->back()->with('success', 'Message added successfully.');
    }

    public function resolve(Request $request, Dispute $dispute)
    {
        $request->validate([
            'resolution' => 'required|string|max:2000',
            'refund_amount' => 'nullable|numeric|min:0',
            'penalty_vendor' => 'nullable|boolean'
        ]);

        DB::transaction(function () use ($request, $dispute) {
            $dispute->update([
                'status' => 'resolved',
                'resolution' => $request->resolution,
                'resolved_at' => now(),
                'resolved_by' => auth()->id()
            ]);

            // Handle refund if applicable
            if ($request->refund_amount > 0) {
                $this->processRefund($dispute, $request->refund_amount);
            }

            // Apply vendor penalty if applicable
            if ($request->boolean('penalty_vendor')) {
                $this->applyVendorPenalty($dispute);
            }
        });

        // Notify parties of resolution
        $dispute->complainant->notify(new DisputeStatusUpdated($dispute));
        $dispute->respondent->notify(new DisputeStatusUpdated($dispute));

        return redirect()->route('admin.disputes.index')
            ->with('success', 'Dispute resolved successfully.');
    }

    private function processRefund(Dispute $dispute, float $amount)
    {
        // Implementation for processing refund through payment gateway
        // This would integrate with Stripe/PayFast refund APIs
    }

    private function applyVendorPenalty(Dispute $dispute)
    {
        // Implementation for applying vendor penalties
        // Could affect vendor rankings, suspend account, etc.
    }
}