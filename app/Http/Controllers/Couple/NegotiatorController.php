<?php

namespace App\Http\Controllers\Couple;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NegotiatorController extends Controller
{
    public function index()
    {
        return view('couple.negotiators');
    }

    public function hire($negotiatorId)
    {
        // Hire negotiator logic
    }

    public function release($negotiatorId)
    {
        // Release negotiator logic
    }
}
