<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;
use Session;

class IsFan
{
   
    public function handle(Request $request, Closure $next)
    {
        if ( Auth::user() ) {
            if ( Auth::user()->user_type == 'users' || Auth::user()->user_type == 'artists' )
            {
                return $next( $request );
            } else {
                return redirect( '/fan/login' );
            }
        } else {
            return redirect( '/fan/login' );

        }
      
    }
}
