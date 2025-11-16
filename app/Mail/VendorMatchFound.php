<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class VendorMatchFound extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public QuoteRequest $quoteRequest,
        public Collection $matches
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Perfect Wedding Vendors Found! 🎉',
            tags: ['vendor-match', 'couple-notification'],
            metadata: [
                'quote_request_id' => $this->quoteRequest->id,
                'matches_count' => $this->matches->count()
            ]
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.vendor-match-found',
            with: [
                'coupleName' => $this->quoteRequest->couple->user->name,
                'matchesCount' => $this->matches->count(),
                'matches' => $this->matches,
                'quoteRequest' => $this->quoteRequest,
                'dashboardUrl' => route('couple.dashboard')
            ]
        );
    }
}