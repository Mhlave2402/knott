<?php

namespace App\Http\Controllers\Couple;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('couple.bookings');
    }

    public function show($bookingId)
    {
        // Show booking details logic
    }

    public function cancel($bookingId)
    {
        // Cancel booking logic
    }
}
