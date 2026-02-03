<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureHeadersMiddleware
{
    /**
     * 🔒 Ajouter les headers de sécurité HTTP sur toutes les réponses
     * Protège contre XSS, Clickjacking, MIME sniffing, etc.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ✅ X-Frame-Options: Empêche clickjacking (interdire embed dans iframe)
        $response->headers->set('X-Frame-Options', 'DENY');

        // ✅ X-Content-Type-Options: Empêche MIME sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // ✅ X-XSS-Protection: Activer XSS protection sur navigateurs vieux
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // ✅ Referrer-Policy: Limiter données envoyées dans Referer header
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // ✅ Permissions-Policy: Désactiver features potentiellement dangereuses
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // ✅ Strict-Transport-Security: Force HTTPS pendant 1 an
        if (env('APP_ENV') === 'production') {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        // ✅ Content-Security-Policy: Protection XSS avancée
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdnjs.cloudflare.com; " .
               "style-src 'self' https://fonts.googleapis.com 'unsafe-inline'; " .
               "img-src 'self' data: https:; " .
               "font-src 'self' https://fonts.gstatic.com; " .
               "connect-src 'self' https:; " .
               "frame-ancestors 'none'; " .
               "base-uri 'self'; " .
               "form-action 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
