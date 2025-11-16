<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index()
    {
        return view('admin.revenue');
    }

    public function earningsReport()
    {
        // Generate earnings report
    }

    public function transactionHistory()
    {
        // Show transaction history
    }
}
