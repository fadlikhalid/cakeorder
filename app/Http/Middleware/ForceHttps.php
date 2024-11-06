<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
{
    // Log the current request scheme
    \Log::info('Request scheme: ' . $request->getScheme());

    if (!$request->secure()) {
        \Log::info('Redirecting to HTTPS');
        return redirect()->secure($request->getRequestUri());
    }

    return $next($request);
}
}