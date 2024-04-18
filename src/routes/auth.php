<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::post('login', [LoginController::class, 'login'])->name('login');
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
    });
});
