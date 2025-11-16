<?php

namespace App\Observers;

use App\Models\QuoteRequest;
use App\Jobs\ProcessAIVendorMatching;

class QuoteRequestObserver
{
    public function created(QuoteRequest $quoteRequest)
    {
        // Log the creation
        \Log::info('New quote request created', [
            'id' => $quoteRequest->id,
            'couple_id' => $quoteRequest->couple_id,
            'budget' => $quoteRequest->total_budget
        ]);
    }
    
    public function updated(QuoteRequest $quoteRequest)
    {
        // If status changed to submitted, trigger AI matching
        if ($quoteRequest->wasChanged('status') && $quoteRequest->status === 'submitted') {
            ProcessAIVendorMatching::dispatch($quoteRequest);
        }
    }
}
