<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

class EmailVerificationHandlerController extends Controller
{
    public function verify(EmailVerificationRequest $request) {

        $request->fulfill();
               
        return redirect('/dashboard')->with([
            'class' => 'success',
            'message' => 'Email verification was <b>successful!</b>'
        ]);

    }
}
