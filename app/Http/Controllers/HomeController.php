<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Event;
use App\Models\Artist_profiles;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminIndex()
    {
        if (Auth::check() && Auth::user()->user_type=='admin')
        
		    {
                $fans_list = User::where('user_type', 'users')->get();
            
                $artist_list = User::where('user_type', 'artists')->get();
                
                $artistrating = Artist_profiles::with('userArtist')->where('ratings','=',5)->get();
                // dd($artistrating);
                $Event_lists = Event::get();
                $Event_list = today()->format('Y-m-d');
                $Event_list = Event::where('event_date', '>=', $Event_list)->get();
               

			    return view('admin.home',compact('fans_list','artist_list','Event_list','artistrating','Event_lists'));
            }
		else
            {
                return view('home');
		    }
    }
    // public function eventlist(){
    //     $event = Event::all();
      
    //     return view('admin.home', compact('event'));
      
    // }
    // public function artistlist()
    // {

    //      $user = User::where('user_type','artists')->get();
    //      $artist_event= Event::where('user_id','>',0)->with('event')->get();
    //       //dd($artist_event[0]->event->user_type);
    //      //printf($data)
    //     return view('admin.home', compact('user','artist_event'));
    // }

    public function index()
    {
        if (Auth::check() && Auth::user()->user_type=='admin')
		    {
			    return view('admin.home');
                
            }
		else
            {
                return view('home');
		    }
    }
}
