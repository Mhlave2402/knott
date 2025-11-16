<?php

namespace App\Listeners;

use App\Events\GiftContributed;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessGiftContribution implements ShouldQueue
{
    public function handle(GiftContributed $event)
    {
        // Process gift contribution and update gift well balance
    }
}
