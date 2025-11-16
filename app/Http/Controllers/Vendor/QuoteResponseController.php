<?php

/**
 * ==============================================
 * VENDOR QUOTE RESPONSE CONTROLLER
 * ==============================================
 * Location: app/Http/Controllers/Vendor/QuoteResponseController.php
 */

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuoteResponseRequest;
use App\Models\QuoteResponse;
use App\Notifications\QuoteSubmittedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QuoteResponseController extends Controller
{
    /**
     * Show pending quote requests for vendor
     */
    public function index(Request $request)
    {
        $vendor = Auth::user()->vendor;
        
        $query = $vendor->quoteResponses()
            ->with(['quoteRequest.couple.user'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by urgency
        if ($request->filled('urgency')) {
            $query->whereHas('quoteRequest', fn($q) => $q->where('urgency', $request->urgency));
        }

        $responses = $query->paginate(12);

        return view('vendor.quotes.index', [
            'responses' => $responses,
            'stats' => $this->getVendorQuoteStats(),
            'filters' => $request->only(['status', 'urgency'])
        ]);
    }

    /**
     * Show quote request details for vendor response
     */
    public function show(QuoteResponse $quoteResponse)
    {
        $this->authorize('view', $quoteResponse);

        $quoteResponse->load([
            'quoteRequest.couple.user',
            'quoteRequest.aiMatchingLogs' => fn($q) => $q->latest()->limit(1)
        ]);

        // Mark as viewed
        if (!$quoteResponse->viewed_at) {
            $quoteResponse->update(['viewed_at' => now()]);
        }

        return view('vendor.quotes.show', [
            'quoteResponse' => $quoteResponse,
            'quoteRequest' => $quoteResponse->quoteRequest,
            'matchReasons' => $quoteResponse->ai_match_reasons ?? [],
            'similarRequests' => $this->getSimilarRequests($quoteResponse),
            'responseTemplate' => $this->getResponseTemplate($quoteResponse)
        ]);
    }

    /**
     * Show quote response form
     */
    public function respond(QuoteResponse $quoteResponse)
    {
        $this->authorize('update', $quoteResponse);

        if ($quoteResponse->status !== 'pending') {
            return redirect()->route('vendor.quotes.show', $quoteResponse)
                ->with('error', 'This quote request has already been responded to.');
        }

        if ($quoteResponse->expires_at && $quoteResponse->expires_at->isPast()) {
            return redirect()->route('vendor.quotes.show', $quoteResponse)
                ->with('error', 'This quote request has expired.');
        }

        return view('vendor.quotes.respond', [
            'quoteResponse' => $quoteResponse,
            'quoteRequest' => $quoteResponse->quoteRequest,
            'vendor' => Auth::user()->vendor,
            'templates' => $this->getQuoteTemplates()
        ]);
    }

    /**
     * Submit quote response
     */
    public function submitResponse(QuoteResponse $quoteResponse, QuoteResponseRequest $request)
    {
        $this->authorize('update', $quoteResponse);

        // Handle file uploads
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('quote-attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
        }

        // Update quote response
        $quoteResponse->update([
            'status' => 'responded',
            'quote_amount' => $request->quote_amount,
            'package_details' => [
                'name' => $request->package_name,
                'description' => $request->package_description,
                'features' => $request->features ?? [],
                'includes' => $request->includes ?? [],
                'excludes' => $request->excludes ?? []
            ],
            'custom_message' => $request->custom_message,
            'attachments' => $attachments,
            'payment_terms' => $request->payment_terms,
            'availability_notes' => $request->availability_notes,
            'responded_at' => now(),
            'expires_at' => now()->addDays($request->quote_validity_days ?? 14)
        ]);

        // Notify couple
        $quoteResponse->quoteRequest->couple->user->notify(
            new QuoteSubmittedNotification($quoteResponse)
        );

        return response()->json([
            'success' => true,
            'message' => 'Quote submitted successfully! The couple will be notified.',
            'redirect' => route('vendor.quotes.show', $quoteResponse)
        ]);
    }

    /**
     * Decline quote request
     */
    public function decline(QuoteResponse $quoteResponse, Request $request)
    {
        $this->authorize('update', $quoteResponse);

        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $quoteResponse->update([
            'status' => 'declined',
            'decline_reason' => $request->reason,
            'declined_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quote request declined.'
        ]);
    }

    /**
     * Send message to couple
     */
    public function sendMessage(QuoteResponse $quoteResponse, Request $request)
    {
        $this->authorize('update', $quoteResponse);

        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $messages = $quoteResponse->messages ?? [];
        $messages[] = [
            'from' => 'vendor',
            'message' => $request->message,
            'timestamp' => now()->toISOString()
        ];

        $quoteResponse->update([
            'messages' => $messages,
            'has_vendor_message' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent to couple.'
        ]);
    }

    /**
     * Get vendor quote statistics
     */
    private function getVendorQuoteStats(): array
    {
        $vendor = Auth::user()->vendor;

        return [
            'total_requests' => $vendor->quoteResponses()->count(),
            'pending_requests' => $vendor->quoteResponses()->pending()->count(),
            'responded_requests' => $vendor->quoteResponses()->responded()->count(),
            'accepted_quotes' => $vendor->quoteResponses()->accepted()->count(),
            'conversion_rate' => $vendor->quoteResponses()->count() > 0 
                ? ($vendor->quoteResponses()->accepted()->count() / $vendor->quoteResponses()->responded()->count()) * 100 
                : 0,
            'average_quote_amount' => $vendor->quoteResponses()->whereNotNull('quote_amount')->avg('quote_amount') ?? 0,
            'average_response_time_hours' => $vendor->quoteResponses()
                ->whereNotNull('responded_at')
                ->get()
                ->avg(fn($response) => $response->created_at->diffInHours($response->responded_at))
        ];
    }

    /**
     * Get similar quote requests for reference
     */
    private function getSimilarRequests(QuoteResponse $quoteResponse): Collection
    {
        $vendor = Auth::user()->vendor;
        $currentRequest = $quoteResponse->quoteRequest;

        return $vendor->quoteResponses()
            ->whereHas('quoteRequest', function ($query) use ($currentRequest) {
                $query->where('id', '!=', $currentRequest->id)
                    ->where(function ($q) use ($currentRequest) {
                        $q->whereBetween('budget', [$currentRequest->budget * 0.8, $currentRequest->budget * 1.2])
                          ->orWhereBetween('guest_count', [$currentRequest->guest_count - 20, $currentRequest->guest_count + 20])
                          ->orWhere('style', $currentRequest->style)
                          ->orWhere('location', 'LIKE', '%' . $currentRequest->location . '%');
                    });
            })
            ->with('quoteRequest')
            ->responded()
            ->limit(3)
            ->get();
    }

    /**
     * Get response template based on quote request
     */
    private function getResponseTemplate(QuoteResponse $quoteResponse): array
    {
        $vendor = Auth::user()->vendor;
        $quoteRequest = $quoteResponse->quoteRequest;

        // Get vendor's average pricing for similar requests
        $avgQuote = $vendor->quoteResponses()
            ->whereHas('quoteRequest', fn($q) => $q->where('style', $quoteRequest->style))
            ->avg('quote_amount');

        return [
            'suggested_amount' => $avgQuote ? round($avgQuote) : null,
            'budget_compatibility' => $this->calculateBudgetCompatibility($quoteRequest->budget, $avgQuote),
            'common_features' => $this->getCommonFeatures($vendor, $quoteRequest),
            'template_message' => $this->generateTemplateMessage($quoteRequest, $quoteResponse)
        ];
    }

    /**
     * Calculate budget compatibility percentage
     */
    private function calculateBudgetCompatibility(int $coupleBudget, ?float $avgQuote): ?int
    {
        if (!$avgQuote) return null;

        $difference = abs($coupleBudget - $avgQuote) / $coupleBudget;
        return max(0, (int) ((1 - $difference) * 100));
    }

    /**
     * Get common features for this vendor's service type
     */
    private function getCommonFeatures($vendor, $quoteRequest): array
    {
        // This could be expanded with ML to analyze successful quotes
        $baseFeatures = [
            'Initial consultation',
            'Custom design proposal',
            'Setup and breakdown',
            'Day-of coordination'
        ];

        // Add style-specific features
        $styleFeatures = [
            'vintage' => ['Vintage props', 'Antique centerpieces'],
            'modern' => ['Clean lines design', 'Contemporary elements'],
            'rustic' => ['Natural materials', 'Outdoor setup options'],
            'elegant' => ['Premium linens', 'Sophisticated arrangements']
        ];

        $features = array_merge($baseFeatures, $styleFeatures[$quoteRequest->style] ?? []);

        return array_slice($features, 0, 8); // Limit to 8 features
    }

    /**
     * Generate template message for quote response
     */
    private function generateTemplateMessage($quoteRequest, $quoteResponse): string
    {
        $coupleName = $quoteResponse->quoteRequest->couple->user->name;
        $weddingDate = $quoteRequest->preferred_date ? $quoteRequest->preferred_date->format('F j, Y') : 'your special day';

        return "Dear {$coupleName},\n\nThank you for considering us for your {$weddingDate} wedding! We're excited about the opportunity to be part of your {$quoteRequest->style} celebration.\n\nBased on your requirements for {$quoteRequest->guest_count} guests, we've crafted a customized package that aligns with your vision and budget.\n\nWe look forward to discussing how we can make your wedding day absolutely perfect!\n\nWarm regards,\n" . Auth::user()->vendor->business_name;
    }

    /**
     * Get quote templates for vendor
     */
    private function getQuoteTemplates(): array
    {
        return [
            'basic' => [
                'name' => 'Essential Package',
                'features' => ['Initial consultation', 'Basic setup', 'Day-of service']
            ],
            'standard' => [
                'name' => 'Complete Package',
                'features' => ['Full consultation', 'Custom design', 'Setup & breakdown', 'Coordination']
            ],
            'premium' => [
                'name' => 'Luxury Package',
                'features' => ['VIP consultation', 'Premium design', 'Full service', 'Dedicated coordinator', 'Emergency support']
            ]
        ];
    }
}