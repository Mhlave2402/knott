<?php

/**
 * ==============================================
 * API ROUTES FOR REAL-TIME UPDATES
 * ==============================================
 * Location: routes/api.php (Add these routes)
 */

Route::middleware(['auth:sanctum'])->group(function () {
    // Quote request status updates
    Route::get('quotes/{quote_request}/status', function (App\Models\QuoteRequest $quoteRequest) {
        return response()->json([
            'status' => $quoteRequest->status,
            'responses_count' => $quoteRequest->quoteResponses()->count(),
            'responded_count' => $quoteRequest->quoteResponses()->responded()->count(),
            'last_update' => $quoteRequest->updated_at->toISOString()
        ]);
    })->name('api.quotes.status');

    // Vendor matching progress
    Route::get('quotes/{quote_request}/matching-progress', function (App\Models\QuoteRequest $quoteRequest) {
        $log = $quoteRequest->aiMatchingLogs()->latest()->first();
        
        return response()->json([
            'processing' => $quoteRequest->status === 'processing',
            'completed' => in_array($quoteRequest->status, ['matched', 'no_matches', 'failed']),
            'matches_found' => $log?->matches_found ?? 0,
            'ai_used' => $log?->ai_used ?? false,
            'processing_time_ms' => $log?->processing_time_ms ?? 0
        ]);
    })->name('api.quotes.matching-progress');

    // Quote response updates for vendors
    Route::get('vendor/quotes/pending-count', function () {
        $vendor = auth()->user()->vendor;
        return response()->json([
            'pending_count' => $vendor->quoteResponses()->pending()->count(),
            'unviewed_count' => $vendor->quoteResponses()->whereNull('viewed_at')->count()
        ]);
    })->name('api.vendor.quotes.pending-count');
});