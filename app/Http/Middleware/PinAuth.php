<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PinAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated (either as master or regular user)
        $userType = Session::get('user_type');
        $userId = Session::get('user_id');
        
        if (!$userType || ($userType === 'user' && !$userId)) {
            return redirect('/login');
        }
        
        return $next($request);
    }
}
