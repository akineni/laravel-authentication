<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function view(Request $request) {

        $user = auth()->user();
        
        return view('dashboard.dashboard', ['username' => $user->username]);
        
    }
}