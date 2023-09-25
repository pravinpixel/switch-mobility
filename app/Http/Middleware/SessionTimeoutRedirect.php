<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SessionTimeoutRedirect
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
        if ($request->hasSession()) { // Check if session exists
            if (auth()->check() && ! $request->session()->has('lastActivityTime')) {
                // Set the last activity time in the session
                $request->session()->put('lastActivityTime', now());
            }
            $lastActivityTime = $request->session()->get('lastActivityTime');
            if (auth()->check() && now()->diffInMinutes($lastActivityTime) >= config('session.lifetime')) {
                // Session has timed out, log the user out and redirect to the login page
                auth()->logout();
                $request->session()->flush();
                return redirect()->route('login'); // Change 'login' to your actual login route name
            }
        }
        return $next($request);
    }
}
