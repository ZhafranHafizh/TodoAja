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
    ->withSchedule(function ($schedule) {
        // Run deadline reminders every 5 minutes
        $schedule->command('reminders:send-deadline-reminders')
                 ->everyFiveMinutes()
                 ->withoutOverlapping()
                 ->runInBackground();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
