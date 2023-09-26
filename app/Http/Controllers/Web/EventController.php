<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Crypt;
use App\Models\Event;
use App\Models\User;
use App\Models\Event_joined_by_fans;
use App\Models\subscriptionplan;
use App\Models\Artist_profiles;
use App\Models\AudioFile;
use App\Models\Eventbooking;
use App\Models\genre;
use App\Models\timezone;
use App\Models\eventduration;
use Carbon\Carbon;
use Session;
class EventController extends Controller
{
         public function eventCreate(Request $request){
          $sc_event = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
          $sc_eventArray = json_decode ($sc_event->content(), true);
          $a_profile = $sc_eventArray['profile'];

          $genre = genre::get();
          // $timezone = timezone::get();
          $eventduration = eventduration::get();

        return view('artistweb.eventcreate',compact('a_profile','genre','eventduration'));
    }

  public function eventstore(Request $request){
    $sc_event = app('App\Http\Controllers\API\EventController')->eventcreate($request);
    $sc_eventArray = json_decode ($sc_event->content(), true);
    $va = $sc_eventArray['success'];
    if($va == 'true'){
      return response()->json($sc_eventArray['event_id']);
    }else{
      if(isset($sc_eventArray['flag']) == 1){
        return response()->json(['status' => 0,'message' => $sc_eventArray['message'], 'flag' => $sc_eventArray['flag']]);
      }else{
      return response()->json(['status' => 0, 'message' => $sc_eventArray['error']]);
      }
    }
  }
  public function eventedit(Request $request,$ids){
    $id = Crypt::decryptString($ids);
    $sc_event = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
    $sc_eventArray = json_decode ($sc_event->content(), true);
    $a_profile = $sc_eventArray['profile'];

    $edit_event = app('App\Http\Controllers\API\EventController')->eventshowweb($id);
    $edit_eventArray = json_decode ($edit_event->content(), true);
    $edit_event = $edit_eventArray['data'];

    $genres = genre::get();
    $timezone = timezone::get();
    $eventduration = eventduration::get();

  return view('artistweb.eventEdit',compact('a_profile','edit_event','genres','timezone','eventduration'));
}
public function eventUpdate(Request $request,$ids){
  $id = $ids;
  $edit_event = app('App\Http\Controllers\API\EventController')->eventupdate($request,$id);
  $edit_eventArray = json_decode ($edit_event->content(), true);

  $va = $edit_eventArray['success'];
  if($va == 'true'){
    return response()->json(['eventid'=>$edit_eventArray['event_id'],'message'=>'Event Updated Successfully']);
  }else{
    if(isset($edit_eventArray['flag']) == 1){
      return response()->json(['status' => 0,'message' => $edit_eventArray['message'], 'flag' => $edit_eventArray['flag']]);
    }else{
    return response()->json(['status' => 0, 'message' => $edit_eventArray['error']]);
    }
    // return response()->json($edit_eventArray['error']);
  }
  
}

  
  public function eventview(Request $request,$ids){
    
    // dd($id);
      $id = Crypt::decryptString($ids);
      $profile = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
      // dd($profile);
      $profileArray = json_decode ($profile->content(), true);
      $a_profile = $profileArray['profile'];

      $sc_event = app('App\Http\Controllers\API\EventController')->eventshowweb($id);
      
      $sc_eventArray = json_decode ($sc_event->content(), true);
      $sc_event = $sc_eventArray['data'];

      $booked = Eventbooking::where('event_id',$id)->where('status',1)->count();

    return view('artistweb.eventDetail',compact('a_profile','sc_event','booked'));
  }

  public function eventDelete($ids){
    $id = Crypt::decryptString($ids);
    $deleteevent = app('App\Http\Controllers\API\EventController')->eventdestroy($id);
    $deleteeventArray = json_decode ($deleteevent->content(), true);
  
    return redirect()->route('artisthome');
    
  }
  public function startevent(Request $request){
    
      $id = $request->event_id;

      $event = Event::where('id',$id)->where('event_status',1)->first();

      $eventstarttime = date("H:i A", strtotime($event->event_time));
      // dd($eventstarttime);
      // date_default_timezone_set("America/New_York");
      // $lastfiveminutes = date('h:i A', strtotime('-5 minutes', strtotime($event->event_time)));
      // $test = '15:14:10 +0800';
      // $t = date('G:i:s',strtotime($current_time));
      // dd($current_time,$eventstarttime,$even,$t);
      $currentdate = strtotime(date("Y-m-d"));
      $todaydate    = strtotime($event->event_date);


      $even = date('H:i A', strtotime('-30 minutes', strtotime($event->event_time)));
      // dd($even);
     
      $event_time_set= timezone::where('id',Auth::user()->timezone)->first();
      $dateNow = Carbon::now();
      $dateNow->setTimezone($event_time_set->region);
      $current_time = date('H:i A',strtotime($dateNow));
      // dd($current_time);
      if($current_time >= $even && $currentdate == $todaydate){
       
      // if(time() >= strtotime($even) && time() <= strtotime($lastfiveminutes)){
        $eventcheck = Event::where('user_id',auth()->user()->id)->where('event_status',1)->where('starteventflag',1)->first();
        // dd($eventcheck);
        // $eventcheck = Event::where('user_id',auth()->user()->id)->where('event_status',1)->where('event_date',Carbon::today())->where('event_time',date("H:i:s"))->where('eventstarttime',null)->first();

        if($eventcheck){

          if($eventcheck->id == $id){

            $event->eventstarttime = Carbon::now();
            $event->starteventflag = 1;
              $event->save();
            return response()->json([
              'success' => true,
              'event_id' => $id,
          ]);
          }else{
            return response()->json([
              'success' => false,
              'flag' => 1,
              'message' => 'You cannot start two events at a  time!',
          ]);
          }
          
        }else{
        $event->eventstarttime = Carbon::now();
        $event->starteventflag = 1;
          $event->save();
        return response()->json([
          'success' => true,
          'event_id' => $id,
      ]);
        }
        
      }else{
        return response()->json([
          'success' => false,
          'flag' => 2,
          'message' => 'You can start the event only 30 Mins ahead of Event Start Time!',
      ]);
      }

      
  }
  public function startendevent(Request $request){
    
    $id = $request->event_id;

    $eventcheck = Event::where('user_id',auth()->user()->id)->where('event_status',1)->where('starteventflag',1)->first();



    $event = Event::where('id',$eventcheck->id)->where('event_status',1)->first();
    if($event){
      $event->event_status = 0;
      $event->golivestatus = 0;
      $event->eventendtime = Carbon::now();
      $event->starteventflag = 0;
      $event->save();

      $eventstart = Event::where('id',$id)->where('event_status',1)->first();
      $eventstart->eventstarttime = Carbon::now();
      $eventstart->starteventflag = 1;
      $eventstart->save();

      return response()->json([
        'success' => true,
        'event_id' => $id,
    ]);
    }
}
  public function artiststartevent(Request $request,$id){
    // $id = Crypt::decryptString($ids);
    $profile = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
      $profileArray = json_decode ($profile->content(), true);
      $a_profile = $profileArray['profile'];

      $sc_event = app('App\Http\Controllers\API\EventController')->eventshowweb($id);
      $sc_eventArray = json_decode ($sc_event->content(), true);
      $sc_event = $sc_eventArray['data'];

      return view('artistweb.golive',compact('a_profile','sc_event'));
  }
  public function endlive(Request $request){
    $id = $request->event_id;
    // $id = Crypt::decryptString($ids);
    $goliveevent = Event::where('id',$id)->where('event_status',1)->first();

    if($goliveevent){
      $goliveevent->event_status = 0;
      $goliveevent->golivestatus = 0;
      $goliveevent->eventendtime = Carbon::now();
      $goliveevent->starteventflag = 0;
      $goliveevent->save();
      return response()->json([
        'success' => true,
        'event_id' => $goliveevent->id,
    ]);
      // $sc_event = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
      //   $sc_eventArray = json_decode ($sc_event->content(), true);
      //   $a_profile = $sc_eventArray['profile'];
      //   $pastEvent = $sc_eventArray['past_event'];
      //   $scheduleEvent = $sc_eventArray['sceduled_event'];
      //   return view('artistweb.home',compact('a_profile','pastEvent','scheduleEvent'));
    }else{
      return response()->json([
        'success' => false,
        'message' => 'You cannot end this event now!',
    ]);
    }
    
  }
  public function golive(Request $request,$ids){
    
    // dd($id);

    $id = Crypt::decryptString($ids);
    $goliveevent = Event::where('id',$id)->where('event_status',1)->first();

    if($goliveevent){
      $goliveevent->golivestatus = 1;
      $goliveevent->save();
    }
      $profile = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
      $profileArray = json_decode ($profile->content(), true);
      $a_profile = $profileArray['profile'];

      $sc_event = app('App\Http\Controllers\API\EventController')->eventshowweb($id);
      $sc_eventArray = json_decode ($sc_event->content(), true);
      $sc_event = $sc_eventArray['data'];

      $audio = AudioFile::where('audio_status',1)->get();

      $audio_value = [];

      foreach($audio as $value){
          $audio_value[$value->audio_name]= $value->audio_file;
      }

    return view('artistweb.liveevent',compact('a_profile','sc_event','audio_value'));
  }
}
