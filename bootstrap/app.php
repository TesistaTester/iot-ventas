<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web( [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Confía en el proxy de Cloud Run para que Laravel detecte
        // correctamente que la petición original fue HTTPS
        // (Cloud Run termina el SSL antes de llegar al contenedor).
        // $middleware->trustProxies(
        //     at: '*',
        //     headers: Request::HEADER_X_FORWARDED_FOR |
        //              Request::HEADER_X_FORWARDED_HOST |
        //              Request::HEADER_X_FORWARDED_PORT |
        //              Request::HEADER_X_FORWARDED_PROTO
        // );        

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
