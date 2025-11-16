<?php

namespace App\Listeners;

use App\Events\VendorsMatched;
use App\Mail\VendorMatchFound;
use App\Notifications\VendorMatchFoundNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendVendorMatchNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(VendorsMatched $event): void
    {
        $couple = $event->quoteRequest->couple;
        
        // Send email to couple
        Mail::to($couple->user->email)->send(
            new VendorMatchFound($event->quoteRequest, $event->matches)
        );

        // Send in-app notification
        $couple->user->notify(
            new VendorMatchFoundNotification($event->quoteRequest, $event->matches)
        );
    }
}