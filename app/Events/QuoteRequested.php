<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuoteRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $couple;
    public $vendor;
    public $service;

    public function __construct($couple, $vendor, $service)
    {
        $this->couple = $couple;
        $this->vendor = $vendor;
        $this->service = $service;
    }
}
