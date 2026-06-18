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
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

if (isset($_SERVER['VERCEL_URL']) || getenv('VERCEL_URL') || getenv('VERCEL')) {
    $tmpPath = '/tmp/storage';
    if (!is_dir($tmpPath)) {
        mkdir($tmpPath, 0755, true);
        mkdir($tmpPath . '/framework/views', 0755, true);
        mkdir($tmpPath . '/framework/sessions', 0755, true);
        mkdir($tmpPath . '/framework/cache', 0755, true);
        mkdir($tmpPath . '/logs', 0755, true);
        mkdir($tmpPath . '/app', 0755, true);
        mkdir($tmpPath . '/bootstrap/cache', 0755, true);
    }
    $app->useStoragePath($tmpPath);
}

return $app;
