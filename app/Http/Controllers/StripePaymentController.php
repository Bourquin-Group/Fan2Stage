<?php
   
namespace App\Http\Controllers;
   
use Stripe;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\subscriptionplan;
use App\Models\Payment;
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        //return $request;
        $artist = $request->user();

        $card_no = 4242424242424242;
        $ccExpiryMonth = 10;
        $cvvNumber =123;
        $ccExpiryYear =2025;

        $input = $request->all();
        $token =  $request->stripeToken;
        $paymentMethod = 'card';
       
        $stripe = new Stripe\StripeClient(env('STRIPE_SECRET'));

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
       
         $subscriptionplan = subscriptionplan::first();
         $orderID = "U".$artist->id."C".$request->coupon_id."P".$subscriptionplan->id."T".$request->tax_percentage;

        if($subscriptionplan){
            $product = \Stripe\Product::create([
             'name' => $subscriptionplan->f2s_plan,
             'type' => 'service',
            ]);

            if(isset($product->id) && $product->id != ''){

                    $interval ='month';
                    $price = \Stripe\Price::create([
                                'product' => $product->id,
                                'unit_amount' =>($request->amount*100),
                                'currency' => 'inr',
                                'recurring' => [
                                        'interval' => $interval,
                                ]
                            ]);

                    $customer = \Stripe\Customer::create([
                                    'name'      => $artist->name.'test',
                                    'email' => $artist->email,
                                    'source'    => $request->stripetoken,
                                    'address'   => [
                                    'line1'       => '',
                                    'postal_code' => '',
                                    'city'        => '',
                                    'state'       => '',
                                    'country'     => '',
                                    ],
                                ]);

                    $subscription = $stripe->subscriptions->create([

                                    'customer' => $customer->id,
                                    'items' => [
                                      ['price' => $price->id],
                              
                                    ],
                                    'metadata' => [
                              
                                      'start_date' => '28-03-2023',
                              
                                      'total_months' => '03',
                              
                                      'end_date' => '28-6-2023'
                              
                                    ]
                              
                                  ]);

                    
                   
            }
            
            $charge =Stripe\Charge::create ([
                        "amount" => 100 * 150,
                        "currency" => "inr",
                        "source" => $request->stripeToken,
                        "description" => "Making test payment." 
                ]);
           
           $data = [
                'user_id' => $artist->id,
                'subscriptionplans_id' =>$subscriptionplan->id,
                'payment_date' =>Carbon::now(),
                'type'  => 1,
                'payment_status' => 1,
                'amount'  => $request->amount,
                'total'=> $request->amount,
                'fans_per_event' => $subscriptionplan->fans_per_event,
                'events_per_month' => $subscriptionplan->events_per_month,
                'stripe_product_id'=> $product->id,
                'stripe_price_id'=> $price->id,
                'stripe_customer_id' => $customer->id,
                'stripe_charge_id' => $charge->id,
           ];
           Payment::create($data);

          
         }


  
        Session::flash('success', 'Payment successful!');
          
        return back();
    }
}