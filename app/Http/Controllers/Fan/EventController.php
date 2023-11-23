<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\timezone;
use Session;

class EventController extends Controller
{
    public function myevent(Request $request){
        $timezone_region = timezone::where('id',Session::get('user_timezone'))->first();
        // dd(Session::get('user_timezone'));
        if(Session::get('user_timezone')){
        date_default_timezone_set($timezone_region['region']);
        }

        $myevent = app('App\Http\Controllers\API\Fans_eventController')->fansEvent($request);
        $myeventArray = json_decode ($myevent->content(), true);
        $pastevent = $myeventArray['past_event'];
        $upcomingevent = $myeventArray['upcoming_event'];
        

        return view('fanweb.myevent',compact('pastevent','upcomingevent','timezone_region'));
    }   
}
