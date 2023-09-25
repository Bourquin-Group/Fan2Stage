<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Payment;
class Subscription
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
        if(Auth::user()->subscription_plan_id && Auth::user()->billinginfo)
        {
            $today = Carbon::now()->format('Y-m-d');
            $validCheck =  Payment::where('id',Auth::user()->current_payment_id)->where('renewal_date','>=',$today)->first();
            if($validCheck)
            {
                return $next($request);
            }else{
                return redirect('/web/subscription');
            }
        }
        else{
            if(Auth::user()->billinginfo){
                return redirect('/web/subscription');
            }else{
                return redirect('/web/billinginfo');
            }
            }
        }
    }

