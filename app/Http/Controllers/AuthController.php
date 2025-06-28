<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'pin' => 'required|numeric',
        ]);

        if ($request->pin == env('APP_PIN')) {
            Session::put('authenticated', true);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['pin' => 'PIN salah.']);
    }

    public function logout()
    {
        Session::forget('authenticated');
        return redirect('/login');
    }
}
