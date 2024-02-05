<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckArtistSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       // Check if the session token matches
    if (auth()->check() && $request->user()->session_id !== session()->getId()) {
        // Log the user out
        auth()->logout();

        // Redirect or handle the logout as needed
        return redirect('/web/login');
    }

    return $next($request);
    }
}
