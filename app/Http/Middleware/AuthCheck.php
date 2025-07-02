<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Log the requested URL
        Log::debug('Requested URL: ' . $request->fullUrl());
    
        if (Auth::check()) {
            // Log if the user is authenticated
            Log::debug('User is already authenticated');
            return $next($request);
        }
    
        // Log the intended URL (before redirecting)
        Log::debug('Storing intended URL: ' . $request->fullUrl());
        session(['url.intended' => $request->fullUrl()]);
    
        return redirect()->route('login.page');
    }
    
}
