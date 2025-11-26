<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\Api\ApplicationApiController;

Route::get('/status', fn() => ['status' => 'API is running']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', fn(Request $r) => $r->user());
    Route::post('/logout', [AuthController::class, 'logout']);

    // Jobs
    Route::get('/jobs', [JobApiController::class, 'index']);
    Route::get('/jobs/{jobVacancy}', [JobApiController::class, 'show']);
    Route::post('/jobs', [JobApiController::class, 'store']);
    Route::put('/jobs/{jobVacancy}', [JobApiController::class, 'update']);
    Route::delete('/jobs/{jobVacancy}', [JobApiController::class, 'destroy']);

    // Applications
    Route::post('/jobs/{jobVacancy}/apply', [ApplicationApiController::class, 'store']);
    Route::get('/applications', [ApplicationApiController::class, 'index']);
});