<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationNoticeController extends Controller
{
    public function notify(Request $request){
        
        if(Auth::user()->hasVerifiedEmail()) return to_route('dashboard');

        return view('auth.verify-email');

    }
}
