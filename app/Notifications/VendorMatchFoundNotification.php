<?php

namespace App\Notifications;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class VendorMatchFoundNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public QuoteRequest $quoteRequest,
        public Collection $matches
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'vendor_match_found',
            'title' => 'Perfect Vendors Found!',
            'message' => "We found {$this->matches->count()} amazing vendors for your wedding",
            'quote_request_id' => $this->quoteRequest->id,
            'matches_count' => $this->matches->count(),
            'action_url' => route('couple.quotes.show', $this->quoteRequest->id),
            'action_text' => 'View Matches',
            'icon' => 'heart',
            'color' => 'success'
        ];
    }
}