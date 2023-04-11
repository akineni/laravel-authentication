<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    SignupController,
    LoginController, 
    LogoutController, 
    EmailVerificationNoticeController,
    EmailVerificationHandlerController,
    EmailVerificationSendController,
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

Route::middleware('guest')->group(function() {

    Route::redirect('/',  '/login');

    Route::view('/login',  'auth.login')->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::view('/signup',  'auth.signup')->name('signup');
    Route::post('/signup', [SignupController::class, 'signup']);

    Route::view('/forgot-password',  'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'request'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'view'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'update'])->name('password.update');

});

Route::middleware(['auth', 'verified'])->group(function() { 

    Route::get('/dashboard', [DashboardController::class, 'view'])->name('dashboard');
    Route::get('/dashboard/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get(
        '/email/verify',
        [EmailVerificationNoticeController::class, 'notify']
    )->withoutMiddleware('verified')->name('verification.notice');

});

Route::get(
    '/email/verify/{id}/{hash}',
    [EmailVerificationHandlerController::class, 'verify']
)->middleware(['auth', 'signed'])->name('verification.verify');

Route::post(
    '/email/verification-notification',
    [EmailVerificationSendController::class, 'send']
)->middleware(['auth', 'throttle:6,1'])->name('verification.send');