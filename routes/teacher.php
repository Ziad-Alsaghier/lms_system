<?php

use App\Http\Controllers\api\v1\teacher\profile\ProfileController;
use App\Http\Controllers\api\v1\teacher\sessions\SessionController;
use Illuminate\Support\Facades\Route;

Route::middleware( ['auth:sanctum','IsTeacher'])->group(function () {
    Route::prefix('session')->group(function () {
        Route::get('/current', [SessionController::class, 'showCurrentMonthSessions']); // Current Month Session: /session/current
        Route::post('/start/{id}', [SessionController::class, 'startSession']); // Start Session: /session/start/{id}
        Route::post('/end/{id}', [SessionController::class, 'endSession']); // End Session: /session/end/{id}
        Route::get('/today', [SessionController::class, 'showCurrentDaySessions']); // Current Day Session: /session/today
        Route::put('/update/{id}', [SessionController::class, 'updateSessionToProcessing']); // Update Session to Processing: /session/update/{id}
    });
    Route::prefix('profile')->group(function () {
        Route::get('show', [ProfileController::class, 'show']); // Show Teacher Profile: /teacher/profile
        Route::get('update', [ProfileController::class, 'update']); // Update Teacher Profile: /teacher/profile/update/{id}
    });
});
