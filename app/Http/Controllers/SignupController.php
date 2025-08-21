<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
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

    public function signup(SignupRequest $request)
    {
        $data = $request->validatedData();
        $this->authService->register($data);

        return redirect('login')->with([
            'class' => 'success',
            'message' => 'Signup was <b>successful!</b>, you can now login'
        ]);
    }
}
