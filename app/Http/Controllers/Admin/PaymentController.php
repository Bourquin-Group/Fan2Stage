<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
    	  $payment = Payment::where('type',1)->get();
    	  return view('admin.paymentlist',compact('payment'));
    }
}
