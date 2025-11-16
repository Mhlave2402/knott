<?php

namespace App\Listeners;

use App\Events\QuoteRequestSent;
use App\Mail\NewQuoteRequest;
use App\Notifications\QuoteRequestReceivedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendQuoteRequestNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(QuoteRequestSent $event): void
    {
        $vendor = $event->quoteResponse->vendor;
        
        // Send email notification to vendor
        Mail::to($vendor->user->email)->send(
            new NewQuoteRequest($event->quoteResponse)
        );

        // Send in-app notification
        $vendor->user->notify(
            new QuoteRequestReceivedNotification($event->quoteResponse)
        );
    }
}
