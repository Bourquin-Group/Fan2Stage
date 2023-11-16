<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Stripe;
use Carbon\Carbon;
use App\Models\User;
use App\Models\fanpayment;
use App\Models\Artist_profiles;
use App\Models\subscriptionplan;
use App\Models\Eventbooking;
use App\Models\Event;
use App\Models\Notification;
use App\Models\billinginformation;
use Illuminate\Support\Facades\Session;

class EventbookingController extends Controller
{
    public function bookevent($id){
        $billdetail = billinginformation::where('user_id',auth()->user()->id)->first();
        if($billdetail){
            $id= base64_decode($id);
            $event = Event::find($id);
            return view('fanweb.bookevent',compact('event'));
        }else{
            Session::flash('billerror', 'please fill the billing information to make payment.');
            return redirect('fan/edit-profile');
        }
        
    }   
    public function tips($id,$amount){
        $billdetail = billinginformation::where('user_id',auth()->user()->id)->first();
        if($billdetail){
            $id= base64_decode($id);
            $event = Event::find($id);
            $amount = base64_decode($amount);
            return view('fanweb.tips',compact('event','amount'));
        }else{
            Session::flash('billerror', 'please fill the billing information to make payment.');
            return redirect('fan/edit-profile');
        }
        
    }   
    // public function subscription(Request $request){
    //     $sc_event = app('App\Http\Controllers\API\SubscriptionPlanController')->subscriptionplanlist($request);
    //     $sc_planArray = json_decode ($sc_event->content(), true);
    //     $plans = $sc_planArray['data'];
    //     $planlist = $plans['subscriptionplan1'];
    //     $expired_status =0;
    //     $today = Carbon::now()->format('Y-m-d');
    //     if(Auth::user()->subscription_plan_id && Auth::user()->current_payment_id)
    //     {
    //         $validCheck =  Payment::where('id',Auth::user()->current_payment_id)->where('renewal_date','>=',$today)->first();
    //             if(!$validCheck)
    //             {
    //                 $expired_status =1;
    //             }
    //     }
    //     return view('fanweb.bookevent',compact('planlist','expired_status'));
    // }
    public function about(Request $request){
        $aboutus = app('App\Http\Controllers\API\CmsManageController')->aboutus();
        $aboutusArray = json_decode ($aboutus->content(), true);
        $aboutus = $aboutusArray['data'];
        return view('artistweb.aboutusContent',compact('aboutus'));
    }
    

    public function subscriptionPost(Request $request)
    {
       
        $event_id =$request->event_id;
        $type = $request->type;
        //type =0 is free plan, 1 is cost plan
        $events = Event::find($event_id);
        // $renewal_date = Carbon::now()->addMonth($events->events_per_month);
        if($type ==0)
        {
            $fan = User::find(auth()->user()->id);
           
            $data = [
                'user_id' => $fan->id,
                'subscriptionplans_id' =>null,
                'payment_date' =>Carbon::now(),
                'type'  => 1,
                'payment_status' => 1,
                'amount'  => 0.00,
                'total'=> 0.00,
                'stripe_product_id'=> Null,
                'stripe_price_id'=> Null,
                'stripe_customer_id' => Null,
                'stripe_charge_id' => Null,
           ];
           $payment = fanpayment::create($data);
           Session::flash('success', "Payment has been success");
          
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
                $fan = User::find(auth()->user()->id);
                $stripe = new Stripe\StripeClient(env('STRIPE_SECRET'));
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                if($events){
                
                                    // $interval =$events->cost;
                                    $billdetail = billinginformation::where('user_id',auth()->user()->id)->first();
                                    if($billdetail){
                                        $customer = \Stripe\Customer::create([
                                            'name'      => $fan->name,
                                            'email' => $fan->email,
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
                                        Session::flash('billerror', 'please fill the billing information to make payment.');
                                        return redirect('fan/edit-profile');
                                    }
                                    

                                    $charge =Stripe\Charge::create ([
                                        "amount" => 100 * ($events->eventamount),
                                        "currency" => "usd",
                                        "source" => $request->stripeToken,
                                        "description" => "Making fan payment." 
                                    ]);

                                    if($charge && $customer)
                                    {
                                        $data = [
                                            'user_id' => $fan->id,
                                            'event_id' => $event_id,
                                            'payment_date' =>Carbon::now(),
                                            'type'  => 1,
                                            'payment_status' => 1,
                                            'amount'  =>$events->eventamount,
                                            'total'=> $events->eventamount,
                                            'stripe_customer_id' => $customer->id,
                                            'stripe_charge_id' => $charge->id,
                                        ];
                                         $payment = fanpayment::create($data);

                                         $inputs = [ 
                                            'artist_id' => $request->artist_id,
                                            'event_id' => $event_id,
                                            'amount' => $events->eventamount,
                                            'payment_status' => 1,
                                            'status' => 1,
                                            'user_id' => auth()->user()->id
                                        ];
                                        $Event = Eventbooking::create($inputs);
                                        
                                    }else{
                                        Session::flash('error', "Payment has been failed. Try again later..");
                                        return redirect()->back();
                                    }  
                }
                Session::flash('paymentsuccess', "Payment has been success");
              
            }catch (Exception $e) {
                Session::flash('error', "Payment has been failed. Try again later..");
                return redirect()->back();
            }   
        }
        return redirect('fan/scheduled-event/'.base64_encode($event_id));
    }

    public function tipspost(Request $request)
    {
       
        $event_id =$request->event_id;
        $type = $request->type;
        //type =0 is free plan, 1 is cost plan
        $events = Event::find($event_id);
        // $renewal_date = Carbon::now()->addMonth($events->events_per_month);
        if($type ==0)
        {
            $fan = User::find(auth()->user()->id);
           
            $data = [
                'user_id' => $fan->id,
                'subscriptionplans_id' =>null,
                'payment_date' =>Carbon::now(),
                'type'  => 1,
                'payment_status' => 1,
                'amount'  => 0.00,
                'total'=> 0.00,
                'stripe_product_id'=> Null,
                'stripe_price_id'=> Null,
                'stripe_customer_id' => Null,
                'stripe_charge_id' => Null,
           ];
           $payment = fanpayment::create($data);
           Session::flash('success', "Payment has been success");
          
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
                $fan = User::find(auth()->user()->id);
                $stripe = new Stripe\StripeClient(env('STRIPE_SECRET'));
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                if($events){
                
                                    // $interval =$events->cost;
                                    $billdetail = billinginformation::where('user_id',auth()->user()->id)->first();
                                    if($billdetail){
                                        $customer = \Stripe\Customer::create([
                                            'name'      => $fan->name,
                                            'email' => $fan->email,
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
                                        Session::flash('billerror', 'please fill the billing information to make payment.');
                                        return redirect('fan/edit-profile');
                                    }
                                    

                                    $charge =Stripe\Charge::create ([
                                        "amount" => 100 * ($request->tips),
                                        "currency" => "usd",
                                        "source" => $request->stripeToken,
                                        "description" => "Making tips payment." 
                                    ]);

                                    if($charge && $customer)
                                    {
                                        $data = [
                                            'user_id' => $fan->id,
                                            'event_id' => $event_id,
                                            'payment_date' =>Carbon::now(),
                                            'type'  => 0,
                                            'payment_status' => 1,
                                            'amount'  =>$request->tips,
                                            'total'=> $request->tips,
                                            'stripe_customer_id' => $customer->id,
                                            'stripe_charge_id' => $charge->id,
                                        ];
                                         $payment = fanpayment::create($data);
                                        
                                    }else{
                                        Session::flash('error', "Payment has been failed. Try again later..");
                                        return redirect()->back();
                                    }  
                }
                Session::flash('paymentsuccess', "Tips for the event success");

              
            }catch (Exception $e) {
                Session::flash('error', "Payment has been failed. Try again later..");
                return redirect()->back();
            }   
        }
        // return redirect('fan/tipsthankyou');
        return view('fanweb.tipsthankyou');
    }

    public function freebookevent($id){
        $id = base64_decode($id);
        $event = Event::where('id',$id)->where('event_status',1)->first();
        $inputs = [ 
            'artist_id' => $event->user_id,
            'event_id' => $id,
            'amount' => 0,
            'payment_status' => 1,
            'status' => 1,
            'user_id' => auth()->user()->id
        ];
        $Event = Eventbooking::create($inputs);
        Session::flash('paymentsuccess', "Event Booked Successfully");
        return redirect('fan/scheduled-event/'.base64_encode($id));
    }
    public function checkprebooking(Request $request){
        $id = $request->id;
        
        $event = Event::where('id', $id)->where('event_status', 1)->first();

        $eventStartTime = $event->event_time;
        $eventEndTime = $event->event_closetime;
        $eventDate = $event->event_date;
        
        $bookings = Eventbooking::whereHas('eventDetail', function ($query) use ($eventStartTime, $eventEndTime, $eventDate) {
            $query->where('event_date', $eventDate)
                ->where(function ($subQuery) use ($eventStartTime, $eventEndTime) {
                    $subQuery->whereBetween('event_time', [$eventStartTime, $eventEndTime])
                        ->orWhereBetween('event_closetime', [$eventStartTime, $eventEndTime]);
                });
        })
        ->where('user_id', Auth::user()->id)
        ->get();
       
        if ($bookings->isEmpty()) {
            return response()->json([
                'success' => true,
                'flag' => 1,
                'event_id'=>base64_encode($request->id),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'flag' => 0,
                'message' => 'You have already booked the event with this time.',
            ]);
            // Session::flash('paymentsuccess', "You have already booked the event with this time.");
            // return redirect('fan/scheduled-event/'.base64_encode($id));
        }
    }
    
    public function cancelbooking(Request $request)
    {
        // stripe cancel payment
        $id=$request->event_id;
        // $stripe = new Stripe\StripeClient(env('STRIPE_SECRET'));
        
        // $fanpaymentid = fanpayment::where('event_id',$id)->where('user_id',Auth::user()->id)->first();
        // $charge_id = $fanpaymentid->stripe_charge_id;
        // $amount = (int) $fanpaymentid->amount;
        // $refund = $stripe->refunds->create([
        //     'charge' => $charge_id,
        //     'amount' => $amount
        // ]);
        // stripe cancel payment
            // if($refund){
        $eventbooking = Eventbooking::where('user_id',Auth::user()->id)->where('event_id',$id)->where('status',1)->first();
        if($eventbooking){
            $eventbooking->status = 0;
            $eventbooking->save();
            Notification::create(['event_booking_id' => $eventbooking->id, 'type' =>4, 'user_id' => auth()->user()->id]);
            
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    
        // }
        // $liveevent = app('App\Http\Controllers\API\EventbookingController')->cancelbookingweb($request);
        // $liveeventArray = json_decode ($liveevent->content(), true);
        // $event = $liveeventArray['booking-status'];
        //  if($event == 'true'){
        //     return redirect()->back();
        //  }
        
    }
    public function checkjoinevent(Request $request){
    
        $id = $request->event_id;
  $artist_id = Event::where(['id' => $id,'event_status' => 1])->first();
        $artistid = $artist_id->user_id;
        $event_id = $request->event_id;
        $usertype = User::where('id',$artistid)->where('user_type','artists')->first();
        $planid = $usertype->subscription_plan_id;
        $f2splan = subscriptionplan::where('id',$planid)->first();
        $fans_per_event = $f2splan->fans_per_event;
        $eventStatus = Event::where(['id' => $event_id,'event_status' => 1])->first();
        if($eventStatus){
            $user_count = Eventbooking::where('artist_id',$artistid)->where('event_id',$event_id)->where('status',1)->pluck('user_id')->toArray();
            // dd($fans_per_event,$user_count);
            if(count($user_count) < $fans_per_event){
                return response()->json([
                    'success' => true,
                    'event_id' => $id,
                    'event_amount' => (int)$eventStatus->eventamount,
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'sorry!! seats for this event is full',
                ]);
            }
        }
    }
}
