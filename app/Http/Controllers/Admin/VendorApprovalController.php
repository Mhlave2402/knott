<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorApprovalController extends Controller
{
    public function index()
    {
        return view('admin.vendor-approvals');
    }

    public function approve($vendorId)
    {
        // Approve vendor logic
    }

    public function reject($vendorId)
    {
        // Reject vendor logic
    }
}
