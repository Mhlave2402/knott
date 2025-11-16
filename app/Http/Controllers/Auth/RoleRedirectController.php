<?php
// FILE: app/Http/Controllers/Auth/RoleRedirectController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class RoleRedirectController extends Controller
{
    /**
     * Redirect user to appropriate dashboard based on their role.
     */
    public function redirectToDashboard(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect('/login');
        }

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'vendor' => redirect()->route('vendor.dashboard'),
            'couple' => redirect()->route('couple.dashboard'),
            'guest' => redirect()->route('guest.dashboard'),
            default => redirect('/login')
        };
    }
}