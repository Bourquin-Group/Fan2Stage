<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
//use App\Http\Requests\SubscriptionPlanRequest;
use App\Models\subscriptionplan;
use App\Models\Payment;
use Carbon\Carbon;
use Auth;
use Mail;

class SubscriptionPlanController extends Controller
{
     public function subscriptionplanlist(Request $request)
    {
    	  $subscriptionplan1 = subscriptionplan::all();
          
    	   if(count($subscriptionplan1) > 0){

            foreach($subscriptionplan1 as $i => $value){
                $data['subscriptionplan1'][$i]['f2s_plan'] = $value->f2s_plan;
                $data['subscriptionplan1'][$i]['fans_per_event'] = $value->fans_per_event;
                $data['subscriptionplan1'][$i]['events_per_month'] = $value->events_per_month;
                $data['subscriptionplan1'][$i]['push_notification'] = $value->push_notification;
                $data['subscriptionplan1'][$i]['favorite_link'] = $value->favorite_link;
                $data['subscriptionplan1'][$i]['cost'] = $value->cost;
                $data['subscriptionplan1'][$i]['cost_value'] = $value->cost_value;
                $data['subscriptionplan1'][$i]['anual_plan'] = $value->anual_plan;
                $data['subscriptionplan1'][$i]['hardware_required'] = $value->hardware_required;
                $data['subscriptionplan1'][$i]['status'] = $value->status;
                $data['subscriptionplan1'][$i]['id'] = $value->id;
            }
            
        $response = [
            'status' => 200,
            'success' => true,
            'data'    => $data,
        ];
        return response()->json($response, 200);
        }else{
            $response = [
                'status' => 404,
                'success' => false,
                'message' => "No Data Found"
            ];
            return response()->json($response, 200);
        }
    }
     public function subscriptionplanlistweb(Request $request)
    {
    	  $subscriptionplan1 = subscriptionplan::where('status',1)->orderBy('ordertype', 'asc')->get();
          
    	   if(count($subscriptionplan1) > 0){

            foreach($subscriptionplan1 as $i => $value){
                $data['subscriptionplan1'][$i]['f2s_plan'] = $value->f2s_plan;
                $data['subscriptionplan1'][$i]['fans_per_event'] = $value->fans_per_event;
                $data['subscriptionplan1'][$i]['events_per_month'] = $value->events_per_month;
                $data['subscriptionplan1'][$i]['push_notification'] = $value->push_notification;
                $data['subscriptionplan1'][$i]['favorite_link'] = $value->favorite_link;
                $data['subscriptionplan1'][$i]['cost'] = $value->cost;
                $data['subscriptionplan1'][$i]['cost_value'] = $value->cost_value;
                $data['subscriptionplan1'][$i]['anual_plan'] = $value->anual_plan;
                $data['subscriptionplan1'][$i]['hardware_required'] = $value->hardware_required;
                $data['subscriptionplan1'][$i]['status'] = $value->status;
                $data['subscriptionplan1'][$i]['id'] = $value->id;
            }
            
        $response = [
            'status' => 200,
            'success' => true,
            'data'    => $data,
        ];
        return response()->json($response, 200);
        }else{
            $response = [
                'status' => 404,
                'success' => false,
                'message' => "No Data Found"
            ];
            return response()->json($response, 200);
        }
    }

     public function artistf2splanlist(Request $request)
    {
          $subscriptionplan = subscriptionplan::where('status',1)->get();
           if(count($subscriptionplan) > 0){
             $data = [];
        $totData = [];
        foreach($subscriptionplan as $value){
            $data['id']=$value->id;
            $data['f2s_plan']=$value->f2s_plan;
            $totData[]=$data;
        }
        $response = [
            'status' => 200,
            'success' => true,
            'data'    => $totData,
        ];
        return response()->json($response, 200);
        }else{
            $response = [
                'status' => 404,
                'success' => false,
                'message' => "No Data Found"
            ];
            return response()->json($response, 200);
        }
    }


    public function f2splanselect(Request $request)
    {
        $id = Auth()->user()->id;
        //dd($id);
        $plan = [
            'subscription_plan_id' => $request->subscription_plan_id,
        ];
            $planUpdate  = User::where('id',$id)->update($plan);

         $response = [
            'status_code'   => 200,
            'status'   => true,
            'message' => 'Plan assigned successfully',
        ];
        return response()->json($response, 200);     



    }

    // Artist API

    public function subscriptionplanlistartist(Request $request)
    {
    	  $subscriptionplan1 = subscriptionplan::all();
          
    	   if(count($subscriptionplan1) > 0){

            foreach($subscriptionplan1 as $i => $value){
                $data['subscriptionplan1'][$i]['f2s_plan'] = $value->f2s_plan;
                $data['subscriptionplan1'][$i]['fans_per_event'] = $value->fans_per_event;
                $data['subscriptionplan1'][$i]['events_per_month'] = $value->events_per_month;
                $data['subscriptionplan1'][$i]['push_notification'] = $value->push_notification;
                $data['subscriptionplan1'][$i]['favorite_link'] = $value->favorite_link;
                $data['subscriptionplan1'][$i]['cost'] = $value->cost;
                $data['subscriptionplan1'][$i]['cost_value'] = $value->cost_value;
                $data['subscriptionplan1'][$i]['anual_plan'] = $value->anual_plan;
                $data['subscriptionplan1'][$i]['hardware_required'] = $value->hardware_required;
                $data['subscriptionplan1'][$i]['status'] = $value->status;
                $data['subscriptionplan1'][$i]['id'] = $value->id;
            }
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
            
        $response = [
            'status' => 200,
            'success' => true,
            'data'    => $data,
            'expiredstatus'=> $expired_status,
            'subscriptionplanid'=> Auth::user()->subscription_plan_id
        ];
        return response()->json($response, 200);
        }else{
            $response = [
                'status' => 404,
                'success' => false,
                'message' => "No Data Found"
            ];
            return response()->json($response, 200);
        }
    }

    public function subscriptionfree(Request $request){
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
                                    $response = [
                                        'status' => 400,
                                        'success' => false,
                                        'message' => "please fill the billing information to make Subscription"
                                    ];
                                    return response()->json($response, 400);
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
                                        $response = [
                                            'status' => 400,
                                            'success' => false,
                                            'message' => "Payment has been failed. Try again later.."
                                        ];
                                        return response()->json($response, 400);
                                    }  
                }
            }catch (Exception $e) {
                $response = [
                    'status' => 400,
                    'success' => false,
                    'message' => "Payment has been failed. Try again later.."
                ];
                return response()->json($response, 400);
            }   
        }
        $artist->update(['subscription_plan_id'=>$subscriptionplan->id,'current_payment_id' => $payment->id]);
            $response = [
                'status' => 200,
                'success' => true,
                'message' => "Subscription Activated Successfully"
            ];
            return response()->json($response, 200);
    }


  
}
