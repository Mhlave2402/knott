<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureVendorApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        if ($user && $user->role === 'vendor') {
            // Check if vendor profile exists
            if (!$user->vendor) {
                return redirect()->route('vendor.profile.create')
                    ->with('error', 'Please create your vendor profile to access the dashboard.');
            }
            
            // Check if vendor is approved
            if (!$user->vendor->is_approved) {
                return redirect()->route('vendor.profile.edit')
                    ->with('error', 'Your vendor account is pending approval. You can update your profile while waiting.');
            }
        }

        return $next($request);
    }
}
