<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateRedirects
{
    public function handle(Request $request, Closure $next)
    {
        // Add your validation logic here before redirection
        
        // Example: Check if the redirect URL is from a trusted domain
        $redirectUrl = $request->input('redirect_url');
        if (!$this->isSafeRedirect($redirectUrl)) {
            // Handle unsafe redirect (e.g., redirect to a safe default page)
            return redirect()->route('safe.default.route');
        }

        return $next($request);
    }

    private function isSafeRedirect($url)
    {
        // Implement your validation logic here
        // Example: Check if the URL is from a trusted domain
        // You may perform checks against a whitelist of allowed domains
        // Return true if safe, false otherwise
    }
}
