<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // The app only ever sits behind the platform reverse proxy on the same host, which
        // terminates TLS. Trusting it lets Laravel see https and the real client address.
        $middleware->trustProxies(at: '*');

        // Content Security Policy on every web response (spatie/laravel-csp)
        $middleware->web(append: [\Spatie\Csp\AddCspHeaders::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
