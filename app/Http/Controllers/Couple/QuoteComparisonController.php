<?php

namespace App\Http\Controllers\Couple;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuoteComparisonController extends Controller
{
    public function index()
    {
        return view('couple.quote-comparison');
    }

    public function compare(Request $request)
    {
        // Compare quotes logic
    }

    public function select($quoteId)
    {
        // Select quote logic
    }
}
