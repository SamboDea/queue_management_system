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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'guest.custom' => \App\Http\Middleware\RedirectIfAuthenticatedCustom::class,
            'nocache' => \App\Http\Middleware\NoCache::class,
        ]);
        
    })
    ->withProviders([
        App\Providers\AuthServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        // $exceptions->renderable(function (Throwable $e, $request) {
        //     $status = method_exists($e, 'getStatusCode')
        //         ? $e->getStatusCode()
        //         : 500;

        //     if (view()->exists("errors.$status")) {
        //         return response()->view("errors.$status", [
        //             'exception' => $e
        //         ], $status);
        //     }
        // });
    })->create();
