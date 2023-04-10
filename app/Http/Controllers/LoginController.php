<?php

namespace App\Http\Controllers;

use Illuminate\Http\{ Request, RedirectResponse };
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request): RedirectResponse {

        $key = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL);

        $credentials = $request->validate([
            'email' => $key ? 'bail|required|email' : 'bail|required',
            'password' => 'bail|required'
        ]);

        if(!$key) {
            $credentials['username'] = $credentials['email'];
            unset($credentials['email']);
        }

        if(Auth::attempt($credentials, filter_var($request->input('remember-me'), FILTER_VALIDATE_BOOLEAN))) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }

        return back()->with([
            'class' => 'danger',
            'message' => 'The provided credentials are <b>Incorrect!</b>'
        ])->onlyInput('email');
    }
}
