<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use App\Services\AuthService;

class LoginController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->credentials();
        $remember = $request->boolean('remember-me');

        if ($this->authService->attemptLogin($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with([
            'class' => 'danger',
            'message' => 'The provided credentials are <b>Incorrect!</b>'
        ])->onlyInput('email');
    }
}
