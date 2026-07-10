<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only decorate HTML responses.
        $contentType = (string) $response->headers->get('Content-Type');
        if ($contentType && ! str_contains($contentType, 'text/html')) {
            return $response;
        }

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(self), camera=(), microphone=()');
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Content-Security-Policy — allows the external services the site relies on
        // (Google Translate, YouTube, OpenStreetMap/Leaflet, Google Fonts). Applied
        // only in production so the Vite dev server / HMR isn't blocked locally.
        if (app()->isProduction()) {
            $csp = implode('; ', [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://translate.google.com https://translate.googleapis.com https://www.gstatic.com https://www.google.com https://unpkg.com",
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://www.gstatic.com https://unpkg.com",
                "img-src 'self' data: https:",
                "font-src 'self' data: https://fonts.gstatic.com",
                "frame-src https://www.youtube.com https://www.youtube-nocookie.com https://www.google.com https://translate.google.com https://www.openstreetmap.org",
                "connect-src 'self' https://translate.googleapis.com https://translate.google.com",
                "object-src 'none'",
                "base-uri 'self'",
                "frame-ancestors 'self'",
                'upgrade-insecure-requests',
            ]);
            $response->headers->set('Content-Security-Policy', $csp);
        }

        return $response;
    }
}
