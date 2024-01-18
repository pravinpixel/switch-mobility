<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class ContentTypeOptions
{

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Add X-Content-Type-Options header
        // $response->headers->set('Content-Type', 'text/html; charset=UTF-8');
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        return $response;
    }
}
