<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PreventMultipleLogins
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->session_id !== session()->getId()) {
            Auth::logout();
            return redirect()->route('login')->with('status', trans('auth.already_logged_in'));
        }

        return $next($request);
    }
}
