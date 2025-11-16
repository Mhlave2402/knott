<?php

/**
 * ==============================================
 * BACKGROUND JOB FOR AI MATCHING PROCESSING
 * ==============================================
 * Location: app/Jobs/ProcessAIMatching.php
 */

namespace App\Jobs;

use App\Models\QuoteRequest;
use App\Services\AiVendorMatchingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Exception;

class ProcessAIMatching implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 300; // 5 minutes
    public int $backoff = 60; // 1 minute between retries

    public function __construct(
        public QuoteRequest $quoteRequest
    ) {}

    public function handle(AiVendorMatchingService $matchingService): void
    {
        try {
            Log::info('Starting AI matching job', [
                'quote_request_id' => $this->quoteRequest->id,
                'couple_id' => $this->quoteRequest->couple_id
            ]);

            // Update quote request status
            $this->quoteRequest->update(['status' => 'processing']);

            // Process the matching
            $result = $matchingService->matchVendorsForQuoteRequest($this->quoteRequest);

            // Update final status
            $this->quoteRequest->update([
                'status' => $result['matches_count'] > 0 ? 'matched' : 'no_matches',
                'processed_at' => now()
            ]);

            Log::info('AI matching job completed successfully', [
                'quote_request_id' => $this->quoteRequest->id,
                'matches_found' => $result['matches_count'],
                'vendors_notified' => $result['vendors_notified']
            ]);

        } catch (Exception $e) {
            Log::error('AI matching job failed', [
                'quote_request_id' => $this->quoteRequest->id,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts()
            ]);

            $this->quoteRequest->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function failed(Exception $exception): void
    {
        Log::error('AI matching job permanently failed', [
            'quote_request_id' => $this->quoteRequest->id,
            'error' => $exception->getMessage()
        ]);

        $this->quoteRequest->update([
            'status' => 'failed',
            'error_message' => 'Matching failed after multiple attempts: ' . $exception->getMessage()
        ]);
    }
}