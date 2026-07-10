<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        // Auto-detect visitor language + set security headers on every web request.
        $middleware->web(append: [
            \App\Http\Middleware\DetectLanguage::class,
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        // Google Translate reads these cookies with client-side JS, so they must
        // not be Laravel-encrypted.
        $middleware->encryptCookies(except: [
            'googtrans',
            'vk_lang_seen',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
