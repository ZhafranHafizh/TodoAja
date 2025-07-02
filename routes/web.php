<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/resend-pin', [AuthController::class, 'resendPin'])->name('resend-pin');
Route::post('/logout', [AuthController::class, 'logout'])->middleware(\App\Http\Middleware\PinAuth::class);

// Protected routes
Route::middleware([\App\Http\Middleware\PinAuth::class])->group(function () {
    Route::get('/dashboard', [ActivityController::class, 'index']);
    Route::resource('activities', ActivityController::class)->except(['index', 'show']);
    Route::patch('/activities/{activity}/status/{status}', [ActivityController::class, 'setStatus'])->name('activities.setStatus');
    Route::patch('/activities/bulk-edit', [ActivityController::class, 'bulkEdit'])->name('activities.bulkEdit');
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
});

Route::get('/', function () {
    return redirect('/dashboard');
});
