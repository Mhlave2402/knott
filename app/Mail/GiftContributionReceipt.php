<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GiftContributionReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $contribution;
    public $guest;

    public function __construct($contribution, $guest)
    {
        $this->contribution = $contribution;
        $this->guest = $guest;
    }

    public function build()
    {
        return $this->markdown('emails.gift-receipt')
                    ->subject('Thank You for Your Gift Contribution!');
    }
}
