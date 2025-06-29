<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;
use Session;

class IsUser
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
        if(Auth::user()){
            if(Auth::user()->user_type == 'artists' || Auth::user()->typeupgrade_status == 1)
            {
                return $next($request);
            }
            else{
                return redirect('/web/login');
            }
        }else{
            return redirect('/web/login');
        }
      
    }
}
