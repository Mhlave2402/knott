<?php

namespace App\Console\Commands;

use App\Models\QuoteResponse;
use Illuminate\Console\Command;

class CleanupExpiredQuotes extends Command
{
    protected $signature = 'quotes:cleanup-expired';
    protected $description = 'Mark expired quote responses as expired';

    public function handle(): int
    {
        $expiredCount = QuoteResponse::where('status', 'pending')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);

        $this->info("Marked {$expiredCount} quote responses as expired.");

        return 0;
    }
}
