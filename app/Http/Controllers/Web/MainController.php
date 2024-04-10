<?php

namespace App\Http\Controllers\web;

use Auth;
use Stripe;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Artist_profiles;
use App\Models\subscriptionplan;
use App\Models\billinginformation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Mail;
class MainController extends Controller
{
    public function subscription(Request $request){
        $sc_event = app('App\Http\Controllers\API\SubscriptionPlanController')->subscriptionplanlistweb($request);
        $sc_planArray = json_decode ($sc_event->content(), true);
        $plans = $sc_planArray['data'];
        $planlist = $plans['subscriptionplan1'];
        $expired_status =0;
        $today = Carbon::now()->format('Y-m-d');
        if(Auth::user()->subscription_plan_id && Auth::user()->current_payment_id)
        {
            $validCheck =  Payment::where('id',Auth::user()->current_payment_id)->where('renewal_date','>=',$today)->first();
                if(!$validCheck)
                {
                    $expired_status =1;
                }
        }
        return view('artistweb.mainContent',compact('planlist','expired_status'));
    }
    public function billinginfo(Request $request){
        $user = billinginformation::where('user_id',auth()->user()->id)->first();
        $getbillinfo = [];
        if($user){
            $getbillinfo['id']     = $user->user_id;
            $getbillinfo['address']     = $user->address;
            $getbillinfo['city']          = $user->city;
            $getbillinfo['state']   = $user->state;
            $getbillinfo['country']   = $user->country;
            $getbillinfo['postalcode']   = $user->postalcode;
            
        } 
        return view('artistweb.billinginfoContent',compact('getbillinfo'));
    }
    public function about(Request $request){
        $aboutus = app('App\Http\Controllers\API\CmsManageController')->aboutus();
        $aboutusArray = json_decode ($aboutus->content(), true);
        $aboutus = $aboutusArray['data'];
        return view('artistweb.aboutusContent',compact('aboutus'));
    }
    

    public function subscriptionPost(Request $request)
    {
       
        $subscription_plan_id =$request->subscription_plan_id;
        $type = $request->type;
        //type =0 is free plan, 1 is cost plan
        $subscriptionplan = subscriptionplan::find($subscription_plan_id);
        $renewal_date = Carbon::now()->addMonth('1');
        if($type ==0)
        {
            $artist = User::find(auth()->user()->id);
           
            $data = [
                'user_id' => $artist->id,
                'subscriptionplans_id' =>$subscriptionplan->id,
                'payment_date' =>Carbon::now(),
                'renewal_date' => $renewal_date,
                'type'  => 1,
                'payment_status' => 1,
                'amount'  => 0.00,
                'total'=> 0.00,
                'fans_per_event' => $subscriptionplan->fans_per_event,
                'events_per_month' => $subscriptionplan->events_per_month,
                'stripe_product_id'=> Null,
                'stripe_price_id'=> Null,
                'stripe_customer_id' => Null,
                'stripe_charge_id' => Null,
           ];
           $payment = Payment::create($data);
           Session::flash('success', "Subscription Activated Successfully");

           $data = array(
            'name' => $artist->name,
        );
        $email = $artist->email;
          Mail::send('mail.subscription',$data,function($message) use($email){
            $message->to($email);
            $message->subject('Congratulations');
            });

          
        }elseif($type ==1){

            $validator = $this->validate($request,[
                'card' => 'required',
                'account_holder_name' => 'required',
                'month' => 'required',
                'year' => 'required',
                'cvv' => 'required'
            ],[
                'card.required' => 'Please Enter Card number',
                'account_holder_name.required' => 'Please Enter Account holder Name',
                'month.required' => 'Please Enter a Month',
                'year.required' => 'Please Enter a Year',
                'cvv.required' => 'Please Enter a CVV',
            ]);
            try {
                $artist = User::find(auth()->user()->id);
                $stripe = new Stripe\StripeClient(env('STRIPE_SECRET'));
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                if($subscriptionplan){
                
                                    $interval =$subscriptionplan->cost;

                                    $billdetail = billinginformation::where('user_id',auth()->user()->id)->first();
                                    $web = User::find(auth()->user()->id);
                                    if($billdetail){
                                    $customer = \Stripe\Customer::create([
                                        'name'      => $request->name,
                                        'email' => $web->email,
                                        'source'    => $request->stripetoken,
                                        'address'   => [
                                        'line1'       => $billdetail->address,
                                        'postal_code' => $billdetail->postal_code,
                                        'city'        => $billdetail->city,
                                        'state'       => $billdetail->state,
                                        'country'     => $billdetail->country,
                                        ],
                                    ]);
                                }else{
                                    Session::flash('error1', "please fill the billing information to make Subscription");
                                    return redirect('web/billinginfo');
                                }
                                    
                                    $charge =Stripe\Charge::create ([
                                        "amount" => 100 * ($subscriptionplan->cost_value),
                                        "currency" => "usd",
                                        "source" => $request->stripeToken,
                                        "description" => "Making test payment." 
                                    ]);

                                    if($charge && $customer)
                                    {
                                        $data = [
                                            'user_id' => $artist->id,
                                            'subscriptionplans_id' =>$subscriptionplan->id,
                                            'payment_date' =>Carbon::now(),
                                            'renewal_date' => $renewal_date,
                                            'type'  => 1,
                                            'payment_status' => 1,
                                            'amount'  =>$subscriptionplan->cost_value,
                                            'total'=> $subscriptionplan->cost_value,
                                            'fans_per_event' => $subscriptionplan->fans_per_event,
                                            'events_per_month' => $subscriptionplan->events_per_month,
                                            'stripe_customer_id' => $customer->id,
                                            'stripe_charge_id' => $charge->id,
                                        ];
                                         $payment = Payment::create($data);
                                         $data = array(
                                            'name' => $artist->name,
                                        );
                                        $email = $artist->email;
                                          Mail::send('mail.subscription',$data,function($message) use($email){
                                            $message->to($email);
                                            $message->subject('Congratulations');
                                            });
                                        
                                    }else{
                                        Session::flash('error', "Payment has been failed. Try again later..");
                                        return redirect()->back();
                                    }  
                }
                Session::flash('success', "Subscription Activated Successfully");
              
            }catch (Exception $e) {
                Session::flash('error', "Payment has been failed. Try again later..");
                return redirect()->back();
            }   
        }
        $artist->update(['subscription_plan_id'=>$subscriptionplan->id,'current_payment_id' => $payment->id]);
        return redirect('web/subscription');
    }

    public function subscriptionPayment($subscription_plan_id)
    {
        $subscriptionplan = subscriptionplan::find($subscription_plan_id);
        return view('artistweb.payment',compact('subscriptionplan'));
    }
}
