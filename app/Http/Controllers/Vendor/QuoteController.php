<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index()
    {
        return view('vendor.quotes');
    }

    public function show($quoteId)
    {
        // Show quote details logic
    }

    public function create(Request $request)
    {
        // Create quote logic
    }

    public function update(Request $request, $quoteId)
    {
        // Update quote logic
    }
}
