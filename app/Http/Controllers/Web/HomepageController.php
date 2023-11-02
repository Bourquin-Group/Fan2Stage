<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Artist_profiles;
use App\Models\User;
use Session;
use App\Models\timezone;
use App\Models\Event;

class HomepageController extends Controller
{
    public function __construct()
    {
        // $timezone_region = timezone::where('id',Session::get('user_timezone'))->first();
        //dd(Session::get('user_timezone'));
        // date_default_timezone_set("Europe/Paris");

        
        // $date=date_create("2013-05-25",timezone_open("Indian/Kerguelen"));
        // date_timezone_set($date,timezone_open("Europe/Paris"));
        

    }
    public function homepage(Request $request){
        $timezone_region = timezone::where('id',Session::get('user_timezone'))->first();
        if(Session::get('user_timezone')){
        date_default_timezone_set($timezone_region['region']);
        }
        
        $sc_event = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
        $sc_eventArray = json_decode ($sc_event->content(), true);
        $a_profile = $sc_eventArray['profile'];
        $pastEvent = $sc_eventArray['past_event'];
        $scheduleEvent = $sc_eventArray['sceduled_event'];
        $liveEvent = $sc_eventArray['live_event'];
        return view('artistweb.home',compact('a_profile','pastEvent','scheduleEvent','liveEvent','timezone_region'));
    
    }
}
