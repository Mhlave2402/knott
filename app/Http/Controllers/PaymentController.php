<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        // Process payment logic
    }

    public function success($paymentId)
    {
        // Handle successful payment
    }

    public function cancel($paymentId)
    {
        // Handle canceled payment
    }
}
