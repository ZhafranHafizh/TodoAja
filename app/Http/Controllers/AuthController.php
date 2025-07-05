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
            'username' => 'required|string|min:3|max:20|unique:users,username|regex:/^[a-zA-Z0-9_]+$/',
        ], [
            'email.unique' => 'An account with this email address already exists. Please use the login page or try a different email address.',
            'username.unique' => 'This username is already taken. Please choose a different username.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'username.min' => 'Username must be at least 3 characters long.',
            'username.max' => 'Username cannot be longer than 20 characters.',
        ]);

        // Generate PIN first
        $pin = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        // Create user with PIN
        $user = User::create([
            'name' => explode('@', $request->email)[0], // Use email prefix as name
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt('dummy'), // We don't use passwords, but field is required
            'pin' => $pin, // Set the PIN during creation
            'pin_generated_at' => now(),
            'is_active' => true,
        ]);
        
        try {
            Mail::to($user->email)->send(new PinNotification($user, $pin, true));
            return redirect()->route('login')->with('success', 'Account created successfully! Check your email for the 4-digit PIN to login with your username: ' . $request->username);
        } catch (\Exception $e) {
            // If email fails, still allow login but show error
            return redirect()->route('login')->with('error', 'Account created but email failed to send. Your PIN is: ' . $pin . ' for username: ' . $request->username);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'pin' => 'required|numeric|digits:4',
        ]);

        // First check if it's the master PIN from .env (with special username 'master')
        if ($request->username === 'master' && $request->pin == env('APP_PIN')) {
            Session::put('authenticated', true);
            Session::put('user_type', 'master');
            return redirect()->intended('/dashboard');
        }

        // Then check if it's a user login with username + PIN
        $user = User::findByUsernameAndPin($request->username, $request->pin);
        
        if ($user) {
            Session::put('authenticated', true);
            Session::put('user_id', $user->id);
            Session::put('user_type', 'user');
            Session::put('user_email', $user->email);
            Session::put('username', $user->username);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['login' => 'Invalid username or PIN. Please check your credentials or create a new account.'])
                    ->withInput($request->only('username'));
    }

    public function resendPin(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:users,username',
        ]);

        $user = User::where('username', $request->username)->first();
        $pin = $user->generatePin();

        try {
            Mail::to($user->email)->send(new PinNotification($user, $pin, false));
            return back()->with('success', 'New PIN sent to your email (' . $user->email . ')!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email. Your new PIN is: ' . $pin);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
