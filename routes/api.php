<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Profile\ProfileController;

// login & register
Route::apiResource('/register', RegisterController::class);
Route::post('/login', [LoginController::class, 'store'])->name('login');

// forgot & reset password
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile/update', [ProfileController::class, 'update']);
    Route::delete('/profile/delete', [ProfileController::class, 'destroy']); 
});