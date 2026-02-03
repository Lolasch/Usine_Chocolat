<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttpsMiddleware
{
    /**
     * 🔒 Forcer HTTPS en production pour éviter Man-in-the-Middle attacks
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si pas HTTPS ET en production -> rediriger
        if (!$request->secure() && env('APP_ENV') === 'production') {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
