<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    SignupController,
    LoginController,
    EmailVerificationController,
    ForgotPasswordController,
    ResetPasswordController,
    DashboardController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::redirect('/', '/login');

    Route::prefix('login')->controller(LoginController::class)->group(function () {
        Route::get('/', 'showLoginForm')->name('login');
        Route::post('/', 'login');
    });

    Route::prefix('signup')->controller(SignupController::class)->group(function () {
        Route::get('/', 'showSignupForm')->name('signup');
        Route::post('/', 'signup');
    });

    Route::prefix('forgot-password')->controller(ForgotPasswordController::class)->group(function () {
        Route::get('/', 'showLinkRequestForm')->name('password.request');
        Route::post('/', 'request')->name('password.email');
    });

    Route::prefix('reset-password')->controller(ResetPasswordController::class)->group(function () {
        Route::get('/{token}', 'showResetPasswordForm')->name('password.reset');
        Route::post('/', 'update')->name('password.update');
    });
});

Route::middleware(
    array_filter([
        'auth',
        config('custom.email_verification') ? 'verified' : null
    ]))
->controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'view')->name('dashboard');
    Route::get('/logout', 'logout')->name('logout');
});

Route::middleware('auth')->prefix('email')->name('verification.')->group(function () {
    Route::prefix('verify')->group(function () {
        Route::get('/', [EmailVerificationController::class, 'notify'])
            ->name('notice');

        Route::get('/{id}/{hash}', [EmailVerificationController::class, 'verify'])
            ->middleware('signed')->name('verify');
    });

    Route::post('/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware('throttle:6,1')->name('send');
});
