<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;

class AuthService
{
    /**
     * Handle login attempt.
     *
     * @param Request $request
     * @return bool
     */
    public function attemptLogin(Request $request): bool
    {
        $key = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL);

        $credentials = $request->validate([
            'email'    => $key ? 'bail|required|email' : 'bail|required',
            'password' => 'bail|required'
        ]);

        if (!$key) {
            $credentials['username'] = $credentials['email'];
            unset($credentials['email']);
        }

        return Auth::attempt(
            $credentials,
            filter_var($request->input('remember-me'), FILTER_VALIDATE_BOOLEAN)
        );
    }

    /**
     * Handle signup process.
     *
     * @param Request $request
     * @return User
     */
    public function register(Request $request): User
    {
        $validated = $request->validate([
            'username' => 'bail|required|unique:App\Models\User|alpha_dash:ascii|regex:/^[a-zA-Z]+/i',
            'email'    => 'bail|required|email|unique:App\Models\User|ends_with:@gmail.com,@yahoo.com',
            'phone'    => 'bail|required|unique:App\Models\User|numeric|digits:11',
            // If you prefer stricter rule, uncomment Password class usage
            // 'password' => ['bail', 'required', 'confirmed',
            //     Password::min(8)
            //         ->letters()
            //         ->mixedCase()
            //         ->numbers()
            //         ->symbols()
            //         ->uncompromised() ],
            'password' => 'bail|required|confirmed|min:8',
            'password_confirmation' => 'bail|required',
            'terms' => 'bail|required'
        ], [
            'username.regex'   => 'Username field cannot start with a number',
            'email.ends_with'  => 'Only gmail & yahoomail accepted',
        ]);

        // Create user
        $user = User::create($validated);

        // Dispatch registration event
        event(new Registered($user));

        return $user;
    }

    /**
     * Send password reset link to the given email.
     *
     * @param Request $request
     * @return string
     */
    public function sendResetLink(Request $request): string
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        return Password::sendResetLink(
            $request->only('email')
        );
    }

    /**
     * Reset the user's password.
     *
     * @param Request $request
     * @return string
     */
    public function reset(Request $request): string
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        return Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password,
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
    }

    /**
     * Log out the authenticated user.
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}