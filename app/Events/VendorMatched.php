<?php

namespace App\Events;

use App\Models\QuoteRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class VendorsMatched implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public QuoteRequest $quoteRequest,
        public Collection $matches
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('couple.' . $this->quoteRequest->couple_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'quote_request_id' => $this->quoteRequest->id,
            'matches_count' => $this->matches->count(),
            'message' => "We found {$this->matches->count()} perfect vendors for your wedding!",
            'matches' => $this->matches->map(fn($match) => [
                'vendor_id' => $match['vendor']->id,
                'vendor_name' => $match['vendor']->business_name,
                'confidence_score' => $match['confidence_score'],
                'avatar' => $match['vendor']->avatar_url
            ])->toArray()
        ];
    }

    public function broadcastAs(): string
    {
        return 'vendors.matched';
    }
}