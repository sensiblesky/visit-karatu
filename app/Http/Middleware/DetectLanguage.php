<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class DetectLanguage
{
    /** Languages we offer beyond the English default. */
    private const SUPPORTED = ['sw', 'fr', 'de'];

    /**
     * On a visitor's first request, pick their language from the browser's
     * Accept-Language header (which reflects their device country / locale) and
     * set the Google Translate `googtrans` cookie so the page renders translated
     * on that same load — no widget, no reload. Runs once; a manual choice in the
     * language menu always wins afterwards.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Already chose a language, or we've already run detection for them.
        if ($request->cookie('googtrans') || $request->cookie('vk_lang_seen')) {
            return $response;
        }

        $preferred = strtolower(substr((string) $request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2));

        if (in_array($preferred, self::SUPPORTED, true)) {
            // `/en/xx` = translate from English into xx. Must be readable by
            // Google's client-side JS (httpOnly=false) and kept raw so the
            // slashes aren't URL-encoded (raw=true), or Translate won't parse it.
            $response->headers->setCookie(
                Cookie::make('googtrans', '/en/'.$preferred, 60 * 24 * 365, '/', null, null, false, true, 'lax')
            );
        }

        // Mark detection done so we don't fight the visitor on later visits.
        // Not httpOnly so the language menu's JS can update it on a manual choice.
        $response->headers->setCookie(
            Cookie::make('vk_lang_seen', '1', 60 * 24 * 365, '/', null, null, false, false, 'lax')
        );

        return $response;
    }
}
