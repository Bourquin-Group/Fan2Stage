<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artist_profiles;
use Auth;
use Mail;
use Session;
use Carbon\Carbon;
use App\Models\Favourite;
use App\Models\contact;
use App\Models\Contactcms;
use App\Models\timezone;
use App\Models\Event_joined_by_fans;
use App\Models\Event;


class ContactController extends Controller
{
    public function contactviewApi(Request $request){
        $contactdetail = Contactcms::where('status',1)->first();
        return response()->json([
            'success' => true,
            'contactdetail' => $contactdetail,
            'message' => 'Contact Details retrieved successfully',
        ],200);
    }

    public function contactsaveApi(Request $request){
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
            'phone.required' => 'Phone is required',
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
    }
}
