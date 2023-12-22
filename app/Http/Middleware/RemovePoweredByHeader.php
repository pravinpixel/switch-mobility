<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemovePoweredByHeader
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->remove('X-Powered-By');

        return $response;
    }
}
