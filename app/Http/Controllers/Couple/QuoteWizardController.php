<?php

namespace App\Http\Controllers\Couple;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuoteWizardController extends Controller
{
    public function index()
    {
        return view('couple.quotes.wizard');
    }

    public function sendRequests(Request $request)
    {
        // Temporary implementation
        return redirect()->route('couple.quotes.index');
    }
}
