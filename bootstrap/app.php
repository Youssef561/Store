<?php

use App\Http\Middleware\CheckUserType;
use App\Http\Middleware\MarkNotificationAsRead;
use App\Http\Middleware\UpdateUserLastActiveAt;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // we use append to make this middleware global and apply in all requests
        $middleware->web(append: [
            UpdateUserLastActiveAt::class,
            MarkNotificationAsRead::class,
        ]);

        // we use alias to add the middleware to specific routes
        $middleware->alias([
            'auth.type' => CheckUserType::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
