<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Events\Registered;

class SignupController extends Controller
{
    public function signup(Request $request) {

        $validated = $request->validate([
            'username' => 'bail|required|unique:App\Models\User|', //alfa_num
            'email' => 'bail|required|email|unique:App\Models\User|ends_with:@gmail.com,@yahoo.com',
            'phone' => 'bail|required|unique:App\Models\User|numeric|digits:11',
            // 'password' => ['bail', 'required', 'confirmed',
            //     Password::min(8)
            //     ->letters()
            //     ->mixedCase()
            //     ->numbers()
            //     ->symbols()
            //     ->uncompromised() ],
            'password' => 'bail|required|confirmed|min:8',
            'password_confirmation' => 'bail|required',
            'terms' => 'bail|required'
        ], [
            'email:ends_with' => 'Only gmail & yahoomail accepted'
        ]);

        $user = User::create($validated);

        event(new Registered($user));

        return redirect('login')->with([
            'class' => 'success',
            'message' => 'Signup was <b>successful!</b>, you can now login'
        ]);

    }
}
