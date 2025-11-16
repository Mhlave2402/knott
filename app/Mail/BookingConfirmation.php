<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $vendor;

    public function __construct($booking, $vendor)
    {
        $this->booking = $booking;
        $this->vendor = $vendor;
    }

    public function build()
    {
        return $this->markdown('emails.booking-confirmation')
                    ->subject('Your Booking Confirmation');
    }
}
