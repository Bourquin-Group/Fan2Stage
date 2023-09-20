<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function myevent(Request $request){
        $myevent = app('App\Http\Controllers\API\Fans_eventController')->fansEvent($request);
        $myeventArray = json_decode ($myevent->content(), true);
        $pastevent = $myeventArray['past_event'];
        $upcomingevent = $myeventArray['upcoming_event'];
        

        return view('fanweb.myevent',compact('pastevent','upcomingevent'));
    }   
}
