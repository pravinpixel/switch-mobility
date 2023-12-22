<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentTypeOptions
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        return $response;
    }
}
