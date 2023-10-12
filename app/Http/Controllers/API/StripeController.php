<?php

namespace App\Http\Controllers\Api;

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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class StripeController extends Controller
{
    public function bookevent($id){
        $id= base64_decode($id);
        $event = Event::find($id);
        return view('fanweb.bookevent',compact('event'));
    }   

    // ------------------------Flutter card detail encryption------------------------

    private string $encryptMethod = 'AES-256-CBC';
    private string $key;
    private string $iv;

    public function __construct()
    {
        $mykey = 'rZvX3gMaTsM12aT90uaElo2ICT0VsewC_Fan2Stage';
        $myiv = '_=8Ee{+>Z=]<@8p_Fan2Stage';
        $this->key = substr(hash('sha256', $mykey), 0, 32);
        $this->iv = substr(hash('sha256', $myiv), 0, 16);
    }

    // ------------------------Flutter card detail encryption------------------------
   
    public function subscriptionPostapi(Request $request)
    {
        $event_id = openssl_decrypt(
            $request->event_id,
            $this->encryptMethod,
            $this->key,
            0,
            $this->iv
        );
        $artist_id = openssl_decrypt(
            $request->artist_id,
            $this->encryptMethod,
            $this->key,
            0,
            $this->iv
        );
        $card = openssl_decrypt(
            $request->card,
            $this->encryptMethod,
            $this->key,
            0,
            $this->iv
        );
        $month = openssl_decrypt(
            $request->month,
            $this->encryptMethod,
            $this->key,
            0,
            $this->iv
        );
        $year = openssl_decrypt(
            $request->year,
            $this->encryptMethod,
            $this->key,
            0,
            $this->iv
        );
        $cvv = openssl_decrypt(
            $request->cvv,
            $this->encryptMethod,
            $this->key,
            0,
            $this->iv
        );
        $account_holder_name = openssl_decrypt(
            $request->account_holder_name,
            $this->encryptMethod,
            $this->key,
            0,
            $this->iv
        );
        // dd($event_id,$artist_id,$card,$month,$year,$cvv,$account_holder_name);
        
        
        // $event_id =$event_id;
        $type = $request->type;
        //type =0 is free plan, 1 is cost plan
        $events = Event::where('id',$event_id)->where('event_status',1)->first();
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
            try {
                $fan = User::find(auth()->user()->id);

                $stripe = new Stripe\StripeClient(env('STRIPE_SECRET'));
                
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $card_details = array(
                    "card" => array(
                    "name" => (string)$account_holder_name,
                    "number" => (string)$card,
                    "exp_month" => (int)$month,
                    "exp_year" => (int)$year,
                    "cvc" => (int)$cvv
                )
                    );
                $stripeToken = $stripe->tokens->create($card_details);
                $eventStatus = Eventbooking::where(['event_id' => $event_id,'artist_id' => $request->artist_id,'status'=> 1,'user_id' => auth()->user()->id])->first();
                if($eventStatus){
                    $response = [
                        'status' => 208,
                        'success'   => false,
                        'message' => 'Event Has Been Booked Already',
                    ];
                    return response()->json($response, 208);
                }else{
                if($events){
                
                                    // $interval =$events->cost;
                                    $billdetail = billinginformation::where('user_id',auth()->user()->id)->first();
                                    if($billdetail){
                                    $customer = \Stripe\Customer::create([
                                        'name'      => $account_holder_name,
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
                                    $response = [
                                        'status' => 208,
                                        'success'   => false,
                                        'message' => 'please fill the billing information to make payment.',
                                    ];
                                    return response()->json($response, 208);
                                }

                                    $charge =Stripe\Charge::create ([
                                        "amount" => 100 * ($events->eventamount),
                                        "currency" => "usd",
                                        "source" => $stripeToken,
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
                                            'artist_id' => $artist_id,
                                            'event_id' => $event_id,
                                            'amount' => $events->eventamount,
                                            'payment_status' => 1,
                                            'status' => 1,
                                            'user_id' => auth()->user()->id
                                        ];
                                        $Event = Eventbooking::create($inputs);
                                        $response = [
                                            'status' => 200,
                                            'success'   => true,
                                            'message' => 'Payment has been success',
                                        ];
                                        return response()->json($response, 200);
                                        
                                    }else{
                                        $response = [
                                            'status' => 404,
                                            'success'   => false,
                                            'message' => 'Payment has been failed. Try again later..',
                                        ];
                                        return response()->json($response, 404);
                                    }  
                    }
                }
            }catch (\Exception $e) {
                $response = [
                    'status' => 406,
                    'success'   => false,
                    'message' => $e->getMessage(),
                    // 'message' => 'Payment has been failed. Try again later..',
                ];
                return response()->json($response, 406);
            }   
        }
    }





    public function subscriptionPost(Request $request)
    {
       
        $event_id =$request->event_id;
        $type = $request->type;
        $input = $request->all();
        $validator = Validator::make($input, [
            'card' => 'required',
            'month' => 'required',
            'year' => 'required',
            'cvv' => 'required',
            'account_holder_name' => 'required',
        ],[
            'card' => 'Please enter a Card number',
            'month' => 'Please enter a Month',
            'year' => 'Please enter a Year',
            'cvv' => 'Please enter a CVV',
            'account_holder_name' => 'Please enter a Account Holder Name',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Invalid params passed',
                'errors' => $validator->errors()
            ], 400);       
        }

        //type =0 is free plan, 1 is cost plan
        $events = Event::where('id',$event_id)->where('event_status',1)->first();
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
           Session::flash('success', "Subscription Activated Successfully");
          
        }elseif($type ==1){
            try {
                $fan = User::find(auth()->user()->id);

                $stripe = new Stripe\StripeClient(env('STRIPE_SECRET'));
                
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $card_details = array(
                    "card" => array(
                    "name" => $request->name,
                    "number" => $request->card,
                    "exp_month" => $request->month,
                    "exp_year" => $request->year,
                    "cvc" => $request->cvv
                )
                    );
                $stripeToken = $stripe->tokens->create($card_details);
                $eventStatus = Eventbooking::where(['event_id' => $event_id,'artist_id' => $request->artist_id,'status'=> 1,'user_id' => auth()->user()->id])->first();
                if($eventStatus){
                    $response = [
                        'status' => 208,
                        'success'   => false,
                        'message' => 'Event Has Been Booked Already',
                    ];
                    return response()->json($response, 208);
                }else{
                if($events){
                
                                    // $interval =$events->cost;
                                    $billdetail = billinginformation::where('user_id',auth()->user()->id)->first();
                                    if($billdetail){
                                    $customer = \Stripe\Customer::create([
                                        'name'      => $request->name,
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
                                    $response = [
                                        'status' => 208,
                                        'success'   => false,
                                        'message' => 'please fill the billing information to make payment.',
                                    ];
                                    return response()->json($response, 208);
                                }

                                    $charge =Stripe\Charge::create ([
                                        "amount" => 100 * ($events->eventamount),
                                        "currency" => "usd",
                                        "source" => $stripeToken,
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
                                        $response = [
                                            'status' => 200,
                                            'success'   => true,
                                            'message' => 'Subscription Activated Successfully',
                                        ];
                                        return response()->json($response, 200);
                                        
                                    }else{
                                        $response = [
                                            'status' => 404,
                                            'success'   => false,
                                            'message' => 'Payment has been failed. Try again later..',
                                        ];
                                        return response()->json($response, 404);
                                    }  
                    }
                }
            }catch (Exception $e) {
                $response = [
                    'status' => 404,
                    'success'   => false,
                    'message' => 'Payment has been failed. Try again later..',
                ];
                return response()->json($response, 404);
            }   
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
    public function tipspost(Request $request)
    {
        $event_id = openssl_decrypt(
            $request->event_id,
            $this->encryptMethod,
            $this->key,
            0,
            $this->iv
        );
        $artist_id = openssl_decrypt(
            $request->artist_id,
            $this->encryptMethod,
            $this->key,
            0,
            $this->iv
        );

        // $event_id =$request->event_id;
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

            // $validator = $this->validate($request,[
            //     'card' => 'required',
            //     'account_holder_name' => 'required',
            //     'month' => 'required',
            //     'year' => 'required',
            //     'cvv' => 'required'
            // ],[
            //     'card.required' => 'Please Enter Card number',
            //     'account_holder_name.required' => 'Please Enter Account holder Name',
            //     'month.required' => 'Please Enter a Month',
            //     'year.required' => 'Please Enter a Year',
            //     'cvv.required' => 'Please Enter a CVV',
            // ]);
            
            $card = openssl_decrypt(
                $request->card,
                $this->encryptMethod,
                $this->key,
                0,
                $this->iv
            );
            $month = openssl_decrypt(
                $request->month,
                $this->encryptMethod,
                $this->key,
                0,
                $this->iv
            );
            $year = openssl_decrypt(
                $request->year,
                $this->encryptMethod,
                $this->key,
                0,
                $this->iv
            );
            $cvv = openssl_decrypt(
                $request->cvv,
                $this->encryptMethod,
                $this->key,
                0,
                $this->iv
            );
            $name = openssl_decrypt(
                $request->account_holder_name,
                $this->encryptMethod,
                $this->key,
                0,
                $this->iv
            );
            $tips = openssl_decrypt(
                $request->tips,
                $this->encryptMethod,
                $this->key,
                0,
                $this->iv
            );
            try {
                $fan = User::find(auth()->user()->id);
                $stripe = new Stripe\StripeClient(env('STRIPE_SECRET'));
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $card_details = array(
                    "card" => array(
                    "name" => $name,
                    "number" => $card,
                    "exp_month" => $month,
                    "exp_year" => $year,
                    "cvc" => $cvv
                )
                    );
                $stripeToken = $stripe->tokens->create($card_details);
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
                                        $response = [
                                            'status' => 208,
                                            'success'   => false,
                                            'message' => 'please fill the billing information to make payment.',
                                        ];
                                        return response()->json($response, 208);
                                    }
                                    

                                    $charge =Stripe\Charge::create ([
                                        "amount" => 100 * ($tips),
                                        "currency" => "usd",
                                        "source" => $stripeToken,
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
                                            'amount'  =>$tips,
                                            'total'=> $tips,
                                            'stripe_customer_id' => $customer->id,
                                            'stripe_charge_id' => $charge->id,
                                        ];
                                         $payment = fanpayment::create($data);
                                         $response = [
                                            'status' => 200,
                                            'success'   => true,
                                            'message' => 'Tips for the event success',
                                        ];
                                        return response()->json($response, 200);
                                        
                                        
                                    }else{
                                        $response = [
                                            'status' => 404,
                                            'success'   => false,
                                            'message' => 'Payment has been failed. Try again later..',
                                        ];
                                        return response()->json($response, 404);
                                    }  
                }

              
            }catch (\Exception $e) {
                $response = [
                    'status' => 404,
                    'success'   => false,
                    'message' => $e->getMessage(),
                    // 'message' => 'Payment has been failed. Try again later..',
                ];
                return response()->json($response, 404);
            }   
        }
    }
}
