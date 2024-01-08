<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // $response->headers->set('Content-Security-Policy', "default-src 'self'");
        // $response->header('Content-Security-Policy', "script-src 'self'");

        return $response;
    }
}
