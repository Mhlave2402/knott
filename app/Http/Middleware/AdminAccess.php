<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'admin') {
            Log::warning('Unauthorized admin access attempt', [
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
                'route' => $request->route()->getName()
            ]);
            
            abort(403, 'Access denied. Admin privileges required.');
        }

        // Log admin actions for audit trail
        Log::info('Admin action', [
            'user_id' => auth()->id(),
            'action' => $request->route()->getName(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return $next($request);
    }
}