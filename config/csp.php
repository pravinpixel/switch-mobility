<?php

return [

    /*
     * A policy will determine which CSP headers will be set. A valid CSP policy is
     * any class that extends `Spatie\Csp\Policies\Policy`
     */
    'policy' => [
        // 'default-src' => [
        //     'self',
        //     // Add other allowed sources here
        // ],
        // 'script-src' => [
        //     'self',
        //     'unsafe-inline',
        //     'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/',
        //     'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js',
        //     'https://code.jquery.com/jquery-3.3.1.slim.min.js',
        //     'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js',
        //     'https://cdn.datatables.net/',
        //     'https://ajax.googleapis.com/',
        //     'https://unpkg.com',
        // ],
        // 'style-src' => [
        //     'self',
        //     'unsafe-inline',
        //     'https://fonts.googleapis.com/css',
        //     'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/',
        //     'unsafe-inline',
        //     'self',
        // ],
        // 'connect-src' => [
        //     'self',
        // ],
        // 'font-src' => [
        //     'self',
        //     'https://fonts.gstatic.com/',
        //     'data:',
        // ],
        // 'frame-src' => [
        //     'none',
        // ],
        // 'object-src' => [
        //     'none',
        // ],
        // Add other directives as needed
    ],

    /*
     * This policy which will be put in report only mode. This is great for testing out
     * a new policy or changes to existing csp policy without breaking anything.
     */
    'report_only_policy' => '',

    /*
     * All violations against the policy will be reported to this url.
     * A great service you could use for this is https://report-uri.com/
     *
     * You can override this setting by calling `reportTo` on your policy.
     */
    'report-uri' => env('CSP_REPORT_URI', null),

    'frame-ancestors' => [
        // Allow the same origin to frame the site
        'self',
        // Prevent framing by other domains
        'none',
    ],
    'form-action' => [
        'self',
        // Add allowed form action sources here
    ],
    'upgrade-insecure-requests' => true,
    'base-uri' => null,
    /*
     * Headers will only be added if this setting is set to true.
     */
    'enabled' => env('CSP_ENABLED', true),

    /*
     * The class responsible for generating the nonces used in inline tags and headers.
     */
    'nonce_generator' => Spatie\Csp\Nonce\RandomString::class,
];
