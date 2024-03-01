<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Cookie;
class PersistentCookie
{
    public function handle($request, Closure $next)
    {
        // Set a persistent cookie expiring in one week
        $cookie = Cookie::make('example_cookie', 'cookie_value', 60 * 24 * 7);
        // Attach the cookie to the response
        return $next($request)->withCookie($cookie);
    }
}