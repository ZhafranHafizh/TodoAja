<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ActivityController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(\App\Http\Middleware\PinAuth::class);

Route::middleware([\App\Http\Middleware\PinAuth::class])->group(function () {
    Route::get('/dashboard', [ActivityController::class, 'index']);
    Route::resource('activities', ActivityController::class)->except(['index', 'show']);
});

Route::get('/', function () {
    return redirect('/dashboard');
});
