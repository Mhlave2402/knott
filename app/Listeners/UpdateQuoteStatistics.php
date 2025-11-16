<?php

namespace App\Listeners;

use App\Events\QuoteResponseSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateQuoteStatistics
{
    public function handle(QuoteResponseSent $event)
    {
        $quoteResponse = $event->quoteResponse;
        $vendor = $quoteResponse->vendor;
        
        // Update vendor statistics
        $vendor->increment('total_quotes_sent');
        
        // Update quote request statistics
        $quoteRequest = $quoteResponse->quoteRequest;
        $quoteRequest->increment('total_quotes_received');
        
        // Update status if this is the first quote
        if ($quoteRequest->total_quotes_received === 1) {
            $quoteRequest->update(['status' => 'quotes_received']);
        }
    }
}