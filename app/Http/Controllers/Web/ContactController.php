<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artist_profiles;
use App\Models\subscriptionplan;
use Auth;
use Mail;
use Session;
use Redirect;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use App\Models\Favourite;
use App\Models\contact;
use App\Models\Contactcms;

class ContactController extends Controller
{
    public function contactView(Request $request){
        $contactdetail = Contactcms::where('status',1)->first();

        $sc_event = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
        $sc_eventArray = json_decode ($sc_event->content(), true);
        $a_profile = $sc_eventArray['profile'];

        return view('artistweb.contact',compact('a_profile','contactdetail'));
    }
    public function contactSave(Request $request){

        $validatedData = $request->validate([
            'first_name' => ['required','string','regex:/^[a-z|A-Z]+(?: [a-z|A-Z]+)*$/'],
            'last_name' => ['required','string','regex:/^[a-z|A-Z]+(?: [a-z|A-Z]+)*$/'],
            'phone' => ['required','numeric','digits:10'],
            'email' => ['required','regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'],
            'comments' => 'required',
        ], [
            'first_name.required' => 'First name is required',
            'first_name.regex' => 'Please enter only characters',
            'last_name.required' => 'Last name is required',
            'last_name.regex' => 'Please enter only characters',
            'phone.required' => 'Phone number is required',
            'phone.digits'=> 'Phone number must be 10 digits',
            'email.required'=> 'Please enter your email',
            'email.regex'=> 'Invalid email address',
            'comments.required' => 'Comment is required',
        ]);

        $input = [
            'user_id' => Auth::user()->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'comments' => $request->comments,
        ];
            $user = contact::create($input);
            $data = array(
                'name' => $user->first_name.' '.$user->last_name,
                'email'  => $user->email,
                'phone'  => $user->phone,
                'comments'  => $user->comments,
            );
            $mail = $user->email;
            Mail::send('mail.contact',$data,function($message) use($mail){
                $message->to($mail);
                $message->subject('Fan2Stage Contact Details');
            });
            return response()->json([
                'success' => true,
                'message' => 'Support Request Received',
            ]);
        // return back()->with('success', 'Support Request Received.');
    }
}
