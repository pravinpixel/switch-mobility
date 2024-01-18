<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddPermissionsPolicyHeader
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // $response->headers->set('Permissions-Policy', 'geolocation=(self "http://designonline.in/switchmobility/public/login"), microphone=(), camera=()');


        return $response;
    }
}
