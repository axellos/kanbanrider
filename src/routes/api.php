<?php

use App\Http\Controllers\Api\User\ProfileInformationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::name('users.me')->prefix('users/me')->group(function () {
        Route::put('', [ProfileInformationController::class, 'update'])->name('update');
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require __DIR__.'/auth.php';
