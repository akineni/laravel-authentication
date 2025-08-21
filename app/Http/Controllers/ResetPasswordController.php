<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showResetPasswordForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function update(Request $request)
    {
        $status = $this->authService->reset($request);

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with([
                'class' => 'success',
                'message' => __($status)
            ])
            : back()->withErrors(['email' => [__($status)]]);
    }
}
