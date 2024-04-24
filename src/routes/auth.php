<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::post('login', [LoginController::class, 'login'])->name('login');

        Route::post('register', [RegisterController::class, 'register'])->name('register');

        Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('password.forgot');

        Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
            ->name('password.reset');
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/email/verify/send', [VerifyEmailController::class, 'sendVerifyLinkEmail'])
            ->name('verification.send');

        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
            ->name('verification.verify');

        Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
    });
});
