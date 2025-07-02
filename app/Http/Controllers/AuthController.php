<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\PinNotification;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ], [
            'email.unique' => 'An account with this email address already exists. Please use the login page or try a different email address.',
        ]);

        // Create user without password, name will be set from email
        $user = User::create([
            'name' => explode('@', $request->email)[0], // Use email prefix as name
            'email' => $request->email,
            'password' => bcrypt('dummy'), // We don't use passwords, but field is required
            'is_active' => true,
        ]);

        // Generate PIN and send email
        $pin = $user->generatePin();
        
        try {
            Mail::to($user->email)->send(new PinNotification($user, $pin, true));
            return redirect()->route('login')->with('success', 'Account created successfully! Check your email for the 4-digit PIN to login.');
        } catch (\Exception $e) {
            // If email fails, still allow login but show error
            return redirect()->route('login')->with('error', 'Account created but email failed to send. Your PIN is: ' . $pin);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'pin' => 'required|numeric|digits:4',
        ]);

        // First check if it's the master PIN from .env
        if ($request->pin == env('APP_PIN')) {
            Session::put('authenticated', true);
            Session::put('user_type', 'master');
            return redirect()->intended('/dashboard');
        }

        // Then check if it's a user PIN (check all users with hashed PIN verification)
        $users = User::where('is_active', true)->get();
        
        foreach ($users as $user) {
            if ($user->verifyPin($request->pin)) {
                Session::put('authenticated', true);
                Session::put('user_id', $user->id);
                Session::put('user_type', 'user');
                Session::put('user_email', $user->email);
                return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors(['pin' => 'Invalid PIN. Please check your PIN or create a new account.']);
    }

    public function resendPin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        $pin = $user->generatePin();

        try {
            Mail::to($user->email)->send(new PinNotification($user, $pin, false));
            return back()->with('success', 'New PIN sent to your email!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email. Your PIN is: ' . $pin);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
