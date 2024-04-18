<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::post('login', [LoginController::class, 'login'])->name('login');
    });
});
