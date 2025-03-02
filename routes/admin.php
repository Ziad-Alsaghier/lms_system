<?php

use App\Http\Controllers\api\v1\admin\category\CategoryController;
use App\Http\Controllers\api\v1\admin\session\SessionController;
use App\Http\Controllers\api\v1\admin\sitteng\TeacherController;
use App\Http\Controllers\api\v1\admin\student\StudentController;
use App\Http\Controllers\api\v1\admin\subject\SubjectController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'IsAdmin'])->group(function () {
    Route::prefix('teacher')->group(function () {
        Route::post('/create', [TeacherController::class, 'store']); // Create: /teacher/create
        // Route::get('/show/{id}', [TeacherController::class, 'show']); // Read: /teacher/show/{id}
        Route::post('/update/{user}', [TeacherController::class, 'update']); // Update: /teacher/update/{user}
        Route::delete('/delete/{id}', [TeacherController::class, 'destroy']); // Delete: /teacher/delete/{id}
    });

    Route::prefix('student')->group(function () {
        Route::post('/create', [StudentController::class, 'store']); // Create: /student/create
        // Route::get('/show/{id}', [StudentController::class, 'show']); // Read: /student/show/{id}
        Route::post('/update/{user}', [StudentController::class, 'update']); // Update: /student/update/{user}
        Route::delete('/delete/{id}', [StudentController::class, 'destroy']); // Delete: /student/delete/{id}
    });

    Route::prefix('session')->group(function () {
        Route::post('/create', [SessionController::class, 'store']); // Create: /create
        Route::get('/show', [SessionController::class, 'index']); // Read: /show
        Route::post('/update/{id}', [SessionController::class, 'update']); // Update: /update/{id}
        Route::delete('/delete/{id}', [SessionController::class, 'destroy']); // Delete: /delete/{id}
        Route::get('/current', [SessionController::class, 'getSessionsForCurrentMonth']); // Current Month Session: /session/current
    });
    Route::prefix('category')->group(function () {
        Route::post('/create', [CategoryController::class, 'store']); // Create: /category/create   
        Route::get('/show', [CategoryController::class, 'index']); // Read: /category/show
        Route::post('/update/{id}', [CategoryController::class, 'update']); // Update: /category/update/{id}
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy']); // Delete: /category/delete/{id}
    });

    Route::prefix('subject')->group(function () {
        Route::post('/create', [SubjectController::class, 'store']); // Create: /subject/create
        Route::get('/show', [SubjectController::class, 'index']); // Read: /subject/show
        Route::post('/update/{id}', [SubjectController::class, 'update']); // Update: /subject/update/{id}
        Route::delete('/delete/{id}', [SubjectController::class, 'destroy']); // Delete: /subject/delete/{id}
    });
});
 
