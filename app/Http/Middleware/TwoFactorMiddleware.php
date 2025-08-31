<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();

        // If logged in but not verified with 2FA
        if ($admin && $admin->two_factor_code) {
            // Prevent access to all admin routes except verification routes
            if (!$request->routeIs('verify')) {
                return redirect()->route('verify');
            }
        }

        return $next($request);
    }
}
