<?php

/**
 * ==============================================
 * COUPLE QUOTE REQUEST CONTROLLER
 * ==============================================
 * Location: app/Http/Controllers/Couple/QuoteRequestController.php
 */

namespace App\Http\Controllers\Couple;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuoteRequestRequest;
use App\Jobs\ProcessAIMatching;
use App\Models\QuoteRequest;
use App\Models\QuoteResponse;
use App\Services\AiVendorMatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteRequestController extends Controller
{
    public function __construct(
        private AiVendorMatchingService $matchingService
    ) {}

    /**
     * Show quote request creation wizard
     */
    public function create()
    {
        return view('couple.quotes.create', [
            'couple' => Auth::user()->couple,
            'existingRequests' => Auth::user()->couple->quoteRequests()->latest()->limit(3)->get()
        ]);
    }

    /**
     * Store new quote request and trigger AI matching
     */
    public function store(QuoteRequestRequest $request)
    {
        $couple = Auth::user()->couple;

        // Create quote request
        $quoteRequest = $couple->quoteRequests()->create([
            'budget' => $request->budget,
            'guest_count' => $request->guest_count,
            'location' => $request->location,
            'preferred_date' => $request->preferred_date,
            'style' => $request->style,
            'special_requirements' => $request->special_requirements,
            'urgency' => $request->urgency,
            'contact_preference' => $request->contact_preference,
            'status' => 'pending'
        ]);

        // Dispatch AI matching job
        ProcessAIMatching::dispatch($quoteRequest);

        return response()->json([
            'success' => true,
            'message' => 'Quote request submitted! Our AI is finding perfect vendors for you.',
            'quote_request_id' => $quoteRequest->id,
            'redirect' => route('couple.quotes.show', $quoteRequest->id)
        ]);
    }

    /**
     * Show quote request details with vendor matches
     */
    public function show(QuoteRequest $quoteRequest)
    {
        $this->authorize('view', $quoteRequest);

        $quoteRequest->load([
            'quoteResponses.vendor.user',
            'quoteResponses.vendor.reviews' => fn($q) => $q->latest()->limit(3)
        ]);

        // Group responses by status
        $responses = [
            'pending' => $quoteRequest->quoteResponses()->pending()->get(),
            'responded' => $quoteRequest->quoteResponses()->responded()->get(),
            'accepted' => $quoteRequest->quoteResponses()->accepted()->get(),
            'rejected' => $quoteRequest->quoteResponses()->rejected()->get()
        ];

        return view('couple.quotes.show', [
            'quoteRequest' => $quoteRequest,
            'responses' => $responses,
            'totalResponses' => $quoteRequest->quoteResponses()->count(),
            'averageQuoteAmount' => $quoteRequest->quoteResponses()->whereNotNull('quote_amount')->avg('quote_amount'),
            'matchingStats' => $this->getMatchingStats($quoteRequest)
        ]);
    }

    /**
     * Compare multiple vendor quotes side-by-side
     */
    public function compare(QuoteRequest $quoteRequest)
    {
        $this->authorize('view', $quoteRequest);

        $responses = $quoteRequest->quoteResponses()
            ->responded()
            ->with(['vendor.user', 'vendor.reviews'])
            ->get();

        if ($responses->count() < 2) {
            return redirect()->route('couple.quotes.show', $quoteRequest)
                ->with('warning', 'You need at least 2 quotes to compare.');
        }

        return view('couple.quotes.compare', [
            'quoteRequest' => $quoteRequest,
            'responses' => $responses,
            'comparisonData' => $this->buildComparisonData($responses)
        ]);
    }

    /**
     * Show page to compare all quotes for a couple
     */
    public function compareQuotes()
    {
        $couple = Auth::user()->couple;

        if (!$couple) {
            return redirect()->route('couple.dashboard')
                ->with('error', 'You must create a couple profile before you can compare quotes.');
        }

        $quoteRequests = $couple->quoteRequests()->with('quoteResponses.vendor')->get();

        // Flatten all responses from all requests
        $responses = $quoteRequests->flatMap(function ($quoteRequest) {
            return $quoteRequest->quoteResponses;
        });

        if ($responses->count() < 2) {
            return redirect()->route('couple.quotes.index')
                ->with('warning', 'You need at least 2 quotes across all your requests to compare.');
        }

        return view('couple.quotes.compare-quotes', [
            'responses' => $responses,
            'comparisonData' => $this->buildComparisonData($responses)
        ]);
    }

    /**
     * Accept a vendor's quote
     */
    public function acceptQuote(QuoteRequest $quoteRequest, QuoteResponse $quoteResponse)
    {
        $this->authorize('update', $quoteRequest);

        // Validate quote response belongs to this request
        if ($quoteResponse->quote_request_id !== $quoteRequest->id) {
            abort(404);
        }

        // Update quote response status
        $quoteResponse->update([
            'status' => 'accepted',
            'accepted_at' => now()
        ]);

        // Auto-reject other pending responses for this request
        $quoteRequest->quoteResponses()
            ->where('id', '!=', $quoteResponse->id)
            ->where('status', 'responded')
            ->update(['status' => 'auto_rejected']);

        return response()->json([
            'success' => true,
            'message' => "Great choice! You've accepted {$quoteResponse->vendor->business_name}'s quote.",
            'redirect' => route('couple.bookings.create', [
                'quote_response' => $quoteResponse->id
            ])
        ]);
    }

    /**
     * Reject a vendor's quote
     */
    public function rejectQuote(QuoteRequest $quoteRequest, QuoteResponse $quoteResponse, Request $request)
    {
        $this->authorize('update', $quoteRequest);

        $quoteResponse->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('reason'),
            'rejected_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quote declined. Vendor has been notified.'
        ]);
    }

    /**
     * Request additional information from vendor
     */
    public function requestInfo(QuoteRequest $quoteRequest, QuoteResponse $quoteResponse, Request $request)
    {
        $this->authorize('update', $quoteRequest);

        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // Add message to quote response
        $messages = $quoteResponse->messages ?? [];
        $messages[] = [
            'from' => 'couple',
            'message' => $request->message,
            'timestamp' => now()->toISOString()
        ];

        $quoteResponse->update([
            'messages' => $messages,
            'has_couple_message' => true
        ]);

        // Notify vendor
        $quoteResponse->vendor->user->notify(
            new \App\Notifications\QuoteInfoRequestNotification($quoteResponse, $request->message)
        );

        return response()->json([
            'success' => true,
            'message' => 'Message sent to vendor.'
        ]);
    }

    /**
     * Retry AI matching for failed requests
     */
    public function retryMatching(QuoteRequest $quoteRequest)
    {
        $this->authorize('update', $quoteRequest);

        if (!in_array($quoteRequest->status, ['failed', 'no_matches'])) {
            return response()->json([
                'success' => false,
                'message' => 'This quote request cannot be retried.'
            ], 422);
        }

        // Reset status and dispatch new job
        $quoteRequest->update([
            'status' => 'pending',
            'error_message' => null
        ]);

        ProcessAIMatching::dispatch($quoteRequest);

        return response()->json([
            'success' => true,
            'message' => 'Retrying vendor matching...'
        ]);
    }

    /**
     * List all quote requests for couple
     */
    public function index()
    {
        $couple = Auth::user()->couple;

        if (!$couple) {
            return view('couple.quotes.index', [
                'quoteRequests' => collect(),
                'stats' => $this->getCoupleQuoteStats()
            ]);
        }

        $quoteRequests = $couple->quoteRequests()
            ->withCount([
                'quoteResponses',
                'quoteResponses as responded_count' => fn($q) => $q->where('status', 'responded'),
                'quoteResponses as accepted_count' => fn($q) => $q->where('status', 'accepted')
            ])
            ->latest()
            ->paginate(10);

        return view('couple.quotes.index', [
            'quoteRequests' => $quoteRequests,
            'stats' => $this->getCoupleQuoteStats()
        ]);
    }

    /**
     * Get matching statistics for a quote request
     */
    private function getMatchingStats(QuoteRequest $quoteRequest): array
    {
        $log = $quoteRequest->aiMatchingLogs()->latest()->first();

        return [
            'processing_time_ms' => $log?->processing_time_ms ?? 0,
            'ai_used' => $log?->ai_used ?? false,
            'matches_found' => $log?->matches_found ?? 0,
            'confidence_scores' => $quoteRequest->quoteResponses()
                ->whereNotNull('ai_confidence_score')
                ->pluck('ai_confidence_score')
                ->toArray()
        ];
    }

    /**
     * Build comparison data for vendor quotes
     */
    private function buildComparisonData($responses): array
    {
        return [
            'price_range' => [
                'min' => $responses->min('quote_amount'),
                'max' => $responses->max('quote_amount'),
                'average' => $responses->avg('quote_amount')
            ],
            'response_times' => $responses->map(function ($response) {
                return [
                    'vendor' => $response->vendor->business_name,
                    'hours' => $response->created_at->diffInHours($response->responded_at ?? now())
                ];
            }),
            'ratings' => $responses->map(function ($response) {
                return [
                    'vendor' => $response->vendor->business_name,
                    'rating' => $response->vendor->average_rating ?? 0,
                    'review_count' => $response->vendor->reviews_count ?? 0
                ];
            }),
            'features_comparison' => $this->buildFeaturesComparison($responses)
        ];
    }

    /**
     * Build features comparison matrix
     */
    private function buildFeaturesComparison($responses): array
    {
        $allFeatures = collect();

        // Extract all unique features from all quotes
        foreach ($responses as $response) {
            if ($response->package_details && isset($response->package_details['features'])) {
                $allFeatures = $allFeatures->merge($response->package_details['features']);
            }
        }

        $uniqueFeatures = $allFeatures->unique()->sort()->values();

        // Build comparison matrix
        return $responses->map(function ($response) use ($uniqueFeatures) {
            $vendorFeatures = $response->package_details['features'] ?? [];
            
            return [
                'vendor' => $response->vendor->business_name,
                'features' => $uniqueFeatures->map(function ($feature) use ($vendorFeatures) {
                    return [
                        'name' => $feature,
                        'included' => in_array($feature, $vendorFeatures)
                    ];
                })
            ];
        })->toArray();
    }

    /**
     * Get quote statistics for couple dashboard
     */
    private function getCoupleQuoteStats(): array
    {
        $couple = Auth::user()->couple;

        if (!$couple) {
            return [
                'total_requests' => 0,
                'active_requests' => 0,
                'total_responses' => 0,
                'accepted_quotes' => 0,
                'average_response_time_hours' => 0,
            ];
        }

        return [
            'total_requests' => $couple->quoteRequests()->count(),
            'active_requests' => $couple->quoteRequests()->whereIn('status', ['pending', 'processing', 'matched'])->count(),
            'total_responses' => QuoteResponse::whereHas('quoteRequest', fn($q) => $q->where('couple_id', $couple->id))->count(),
            'accepted_quotes' => QuoteResponse::whereHas('quoteRequest', fn($q) => $q->where('couple_id', $couple->id))->where('status', 'accepted')->count(),
            'average_response_time_hours' => QuoteResponse::whereHas('quoteRequest', fn($q) => $q->where('couple_id', $couple->id))
                ->whereNotNull('responded_at')
                ->get()
                ->avg(fn($response) => $response->created_at->diffInHours($response->responded_at))
        ];
    }
}
