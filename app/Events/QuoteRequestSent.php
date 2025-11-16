<?php

namespace App\Events;

use App\Models\QuoteResponse;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuoteRequestSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public QuoteResponse $quoteResponse
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('vendor.' . $this->quoteResponse->vendor_id),
        ];
    }

    public function broadcastWith(): array
    {
        $quoteRequest = $this->quoteResponse->quoteRequest;
        
        return [
            'quote_response_id' => $this->quoteResponse->id,
            'quote_request_id' => $quoteRequest->id,
            'couple_name' => $quoteRequest->couple->user->name,
            'wedding_date' => $quoteRequest->preferred_date?->format('M j, Y'),
            'guest_count' => $quoteRequest->guest_count,
            'budget' => 'R' . number_format($quoteRequest->budget),
            'location' => $quoteRequest->location,
            'confidence_score' => $this->quoteResponse->ai_confidence_score,
            'expires_at' => $this->quoteResponse->expires_at->format('M j, Y g:i A'),
            'message' => 'New quote request perfectly matched to your services!'
        ];
    }

    public function broadcastAs(): string
    {
        return 'quote.request.received';
    }
}