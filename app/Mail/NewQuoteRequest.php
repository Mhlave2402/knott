<?php

namespace App\Mail;

use App\Models\QuoteResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewQuoteRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public QuoteResponse $quoteResponse
    ) {}

    public function envelope(): Envelope
    {
        $quoteRequest = $this->quoteResponse->quoteRequest;
        
        return new Envelope(
            subject: 'New Wedding Quote Request - Perfect Match! 💍',
            tags: ['quote-request', 'vendor-notification'],
            metadata: [
                'quote_response_id' => $this->quoteResponse->id,
                'confidence_score' => $this->quoteResponse->ai_confidence_score
            ]
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.new-quote-request',
            with: [
                'vendorName' => $this->quoteResponse->vendor->business_name,
                'coupleName' => $this->quoteResponse->quoteRequest->couple->user->name,
                'confidenceScore' => $this->quoteResponse->ai_confidence_score,
                'quoteRequest' => $this->quoteResponse->quoteRequest,
                'expiresAt' => $this->quoteResponse->expires_at,
                'respondUrl' => route('vendor.quotes.respond', $this->quoteResponse->id)
            ]
        );
    }
}