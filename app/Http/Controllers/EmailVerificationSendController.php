<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailVerificationSendController extends Controller
{
    public function send(Request $request) {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with([
            'class' => 'success',
            'message' => 'Verification link <b>sent!</b>'
        ]);
    }
}
