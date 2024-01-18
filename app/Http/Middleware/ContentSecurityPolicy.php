<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // $response->header("Content-Security-Policy: default-src 'none'; script-src 'self';
        // connect-src 'self'; img-src 'self'; style-src 'self' 'unsafe-inline';");
        // $response->header('Content-Security-Policy', "frame-ancestors 'self'");
        // $response->header("X-XSS-Protection: 1; mode=block");
        return $response;
    }
}
