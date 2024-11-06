<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Other middleware...
        \App\Http\Middleware\ForceHttps::class, // Add your middleware here
    ];

    protected $middlewareGroups = [
        'web' => [
            // Other web middleware...
            \App\Http\Middleware\ForceHttps::class, // Add your middleware here as well
        ],
    ];

    protected $routeMiddleware = [
        // Route specific middleware
    ];
}

