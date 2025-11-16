<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorMatchNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $couple;
    public $vendor;

    public function __construct($couple, $vendor)
    {
        $this->couple = $couple;
        $this->vendor = $vendor;
    }

    public function build()
    {
        return $this->markdown('emails.vendor-match')
                    ->subject('New Vendor Match for Your Wedding!');
    }
}
