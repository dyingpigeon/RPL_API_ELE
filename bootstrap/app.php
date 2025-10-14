<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan middleware alias di sini
        $middleware->alias([
            'token.check' => App\Http\Middleware\CheckTokenExpiration::class,
        ]);
        
        // Atau untuk middleware global
        // $middleware->append(App\Http\Middleware\CheckTokenExpiration::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();