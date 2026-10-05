<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

    // Trust proxy/ngrok agar Laravel mengenali HTTPS
    $middleware->trustProxies(at: '*');

    // Kecualikan route callback Midtrans dari proteksi CSRF
    $middleware->validateCsrfTokens(except: [
        'midtrans-callback',
        'api/midtrans-callback',
    ]);

    // Mendaftarkan alias middleware 'role'
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();