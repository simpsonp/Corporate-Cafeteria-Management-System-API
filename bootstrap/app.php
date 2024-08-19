<?php

use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use App\Http\Middleware\BasicOrTokenAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        // Instruct Laravel that incoming requests from the SPA can authenticate using Laravel's session cookies
        $middleware->statefulApi();

        // Note: Instead of aliases, use class names for custom or less common middleware
        // for readability and maintenance, especially in a team environment
        $middleware->alias([
            'x.auth.basicOrToken' => BasicOrTokenAuth::class,
            'x.auth.onceBasic' => AuthenticateOnceWithBasicAuth::class
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
