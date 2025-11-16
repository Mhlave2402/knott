<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GiftWellController extends Controller
{
    public function index()
    {
        return view('guest.gift-well');
    }

    public function contribute($giftWellId)
    {
        // Show contribution form logic
    }
}
