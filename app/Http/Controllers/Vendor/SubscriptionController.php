<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('vendor.subscription');
    }

    public function subscribe($planId)
    {
        // Subscribe to plan logic
    }

    public function cancel()
    {
        // Cancel subscription logic
    }
}
