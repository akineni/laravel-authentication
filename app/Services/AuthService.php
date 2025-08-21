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
    public function attemptLogin(array $credentials, bool $remember = false): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    /**
     * Handle signup process.
     *
     * @param Request $request
     * @return User
     */
    public function register(array $data): User
    {
        $user = User::create($data);

        if (config('custom.email_verification')) {
            event(new Registered($user));
        }

        return $user;
    }

    /**
     * Send password reset link to the given email.
     *
     * @param Request $request
     * @return string
     */
    public function sendResetLink(array $data): string
    {
        return Password::sendResetLink($data);
    }

    /**
     * Reset the user's password.
     *
     * @param Request $request
     * @return string
     */
    public function reset(array $data): string
    {
        return Password::reset($data, function (User $user, string $password) {
            $user->forceFill([
                'password' => $password,
            ])->setRememberToken(Str::random(60));
            $user->save();
            event(new PasswordReset($user));
        });
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