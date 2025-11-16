<?php
// FILE: app/Http/Controllers/Vendor/DashboardController.php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $stats = [
            'active_quotes' => 0, // TODO: Implement in Phase 3
            'total_bookings' => 0,
            'monthly_revenue' => 0,
            'profile_completion' => 50, // TODO: Calculate from vendor profile
        ];

        return view('vendor.dashboard', compact('stats'));
    }
}