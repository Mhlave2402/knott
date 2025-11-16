<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $couple;
    public $vendor;
    public $service;

    public function __construct($couple, $vendor, $service)
    {
        $this->couple = $couple;
        $this->vendor = $vendor;
        $this->service = $service;
    }

    public function build()
    {
        return $this->markdown('emails.quote-request')
                    ->subject('New Quote Request for Your Service!');
    }
}
