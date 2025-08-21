<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class SignupController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        $this->authService->register($request);

        return redirect('login')->with([
            'class' => 'success',
            'message' => 'Signup was <b>successful!</b>, you can now login'
        ]);
    }
}
