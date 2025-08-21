<?php

namespace App\Http\Controllers;

use Illuminate\Http\{ Request, RedirectResponse };
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function view(Request $request) {

        $user = auth()->user();
        
        return view('dashboard.dashboard', ['username' => $user->username]);
        
    }

    public function logout(Request $request): RedirectResponse {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}