<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class WebhookController extends Controller
{
    public function webhook(){
            
           //require 'vendor/autoload.php';
            
            $endpoint_secret = 'whsec_f925fea85c7ac77694516a1859f853136a61cb74fb71020b8e09abc5eb2b7769';

            $payload = @file_get_contents('php://input');
            //dd( $payload);
            print_r($_SERVER);
            $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
            $event = null;

            try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
            } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
            } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
            }

            // Handle the event
            switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
            }

            http_response_code(200);
    }
}
