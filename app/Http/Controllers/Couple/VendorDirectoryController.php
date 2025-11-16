<?php

namespace App\Http\Controllers\Couple;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorDirectoryController extends Controller
{
    public function index()
    {
        $vendors = \App\Models\VendorProfile::with(['user', 'services'])
            ->whereHas('user', function($query) {
                $query->where('role', 'vendor');
            })
            ->get();

        return view('couple.vendors.index', compact('vendors'));
    }
}
