<?php

use App\Http\Middleware\AdminAuthentication;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\UserAuthentication;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => AuthMiddleware::class,
            'user' => UserAuthentication::class,
            'admin' => AdminAuthentication::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

    })->create();
