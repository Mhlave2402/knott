<?php
// FILE: app/Http/Controllers/Guest/DashboardController.php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $stats = [
            'total_contributions' => 0, // TODO: Implement in Phase 4
            'active_gift_wells' => 0,
        ];

        return view('guest.dashboard', compact('stats'));
    }
}