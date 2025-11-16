<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorDirectoryController extends Controller
{
    public function index()
    {
        return view('public.vendor-directory');
    }

    public function show($vendorId)
    {
        // Show vendor profile logic
    }
}
