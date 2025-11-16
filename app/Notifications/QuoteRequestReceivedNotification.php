<?php

namespace App\Notifications;

use App\Models\QuoteResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuoteRequestReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public QuoteResponse $quoteResponse
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        $quoteRequest = $this->quoteResponse->quoteRequest;
        
        return [
            'type' => 'quote_request_received',
            'title' => 'New Quote Request!',
            'message' => "Perfect match from {$quoteRequest->couple->user->name} - {$this->quoteResponse->ai_confidence_score}% compatibility",
            'quote_response_id' => $this->quoteResponse->id,
            'couple_name' => $quoteRequest->couple->user->name,
            'budget' => $quoteRequest->budget,
            'confidence_score' => $this->quoteResponse->ai_confidence_score,
            'expires_at' => $this->quoteResponse->expires_at,
            'action_url' => route('vendor.quotes.respond', $this->quoteResponse->id),
            'action_text' => 'Respond to Quote',
            'icon' => 'dollar-sign',
            'color' => 'primary'
        ];
    }
}