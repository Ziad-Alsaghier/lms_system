<?php

use App\Http\Middleware\IsActive;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsTeacher;
use App\Models\SessionClass;
use App\Observers\SetBackageObserver;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
        Route::middleware(['api','auth:sanctum','IsAdmin'])
        ->prefix('admin')
        ->name('admin')
        ->group(base_path('routes/admin.php'));
        Route::middleware(['api','auth:sanctum','IsTeacher'])
        ->prefix('teacher')
        ->name('teacher')
        ->group(base_path('routes/teacher.php'));
        
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        //  
        $middleware->alias([
            'IsTeacher'=>IsTeacher::class,
            'IsAdmin'=>IsAdmin::class,
            'IsActive'=>IsActive::class,
                'User' => App\Models\User::class,

        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        SessionClass::observe(SetBackageObserver::class);
        
    })->create();
