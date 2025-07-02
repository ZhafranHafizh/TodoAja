<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PinAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::get('authenticated')) {
            return redirect('/login');
        }
        return $next($request);
    }
}
