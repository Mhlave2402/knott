<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GiftContributed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $contribution;
    public $guest;

    public function __construct($contribution, $guest)
    {
        $this->contribution = $contribution;
        $this->guest = $guest;
    }
}
