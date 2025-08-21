<?php

namespace App\Services;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationService
{
    /**
     * Fulfill email verification.
     *
     * @param EmailVerificationRequest $request
     * @return void
     */
    public function verify(EmailVerificationRequest $request): void
    {
        $request->fulfill();
    }

    /**
     * Check if the user needs verification.
     *
     * @param Request $request
     * @return bool
     */
    public function needsVerification(Request $request): bool
    {
        return !Auth::user()->hasVerifiedEmail();
    }

    /**
     * Send email verification link.
     *
     * @param Request $request
     * @return void
     */
    public function send(Request $request): void
    {
        $request->user()->sendEmailVerificationNotification();
    }
}
