<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public authentication DISABLED
|--------------------------------------------------------------------------
| Login, registration and password-reset are turned off for this public
| showcase build. The route NAMES are kept (so existing route('login') /
| route('register') references don't break) but GET requests redirect home
| and POST requests are rejected — no one can sign in or create an account.
|
| TO RE-ENABLE: delete this block and restore the original Breeze routes
| (the controller-backed register/login/forgot-password/reset-password
| routes that previously lived here).
*/
Route::middleware('guest')->group(function () {
    $redirectHome = fn () => redirect()->route('home');
    $blocked = fn () => abort(403, 'This feature is currently disabled.');

    Route::get('register', $redirectHome)->name('register');
    Route::get('login', $redirectHome)->name('login');
    Route::get('forgot-password', $redirectHome)->name('password.request');
    Route::get('reset-password/{token}', $redirectHome)->name('password.reset');

    Route::post('register', $blocked);
    Route::post('login', $blocked);
    Route::post('forgot-password', $blocked)->name('password.email');
    Route::post('reset-password', $blocked)->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
