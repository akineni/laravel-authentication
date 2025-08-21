<?php

namespace App\Http\Controllers;

use Illuminate\Http\{ Request, RedirectResponse };
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

    public function login(Request $request): RedirectResponse
    {
        if ($this->authService->attemptLogin($request)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with([
            'class' => 'danger',
            'message' => 'The provided credentials are <b>Incorrect!</b>'
        ])->onlyInput('email');
    }
}
