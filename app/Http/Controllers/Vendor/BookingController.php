<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('vendor.bookings');
    }

    public function show($bookingId)
    {
        // Show booking details logic
    }

    public function update(Request $request, $bookingId)
    {
        // Update booking status logic
    }
}
