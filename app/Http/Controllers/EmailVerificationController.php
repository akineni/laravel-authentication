<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Services\EmailVerificationService;

class EmailVerificationController extends Controller
{
    protected EmailVerificationService $emailVerificationService;

    public function __construct(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    public function verify(EmailVerificationRequest $request)
    {
        $this->emailVerificationService->verify($request);

        return redirect('/dashboard')->with([
            'class' => 'success',
            'message' => 'Email verification was <b>successful!</b>'
        ]);
    }

    public function notify(Request $request)
    {
        if (! $this->emailVerificationService->needsVerification($request)) {
            return to_route('dashboard');
        }

        return view('auth.verify-email');
    }

    public function send(Request $request)
    {
        $this->emailVerificationService->send($request);

        return back()->with([
            'class' => 'success',
            'message' => 'Verification link <b>sent!</b>'
        ]);
    }
}
