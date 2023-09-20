<?php

namespace App\Http\Controllers\Web;

use Auth;
use Crypt;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event_joined_by_fans;
use App\Models\fansactivitygraph;
use DB;
class EventHistoryController extends Controller
{
    public function eventHistory(Request $request){
           $event_history_data = app('App\Http\Controllers\API\ArtistController')->eventhistory($request);
            $event_history_data = json_decode ($event_history_data->content(), true);
             $event_history = $event_history_data['data'];

        return view('artistweb.eventhistory',compact('event_history'));
    }

    public function eventHistoryDetails($id)
    {

      //return  date("g:i a", strtotime("12 am GMT"));
         $eventHistory = Event::find($id);
         $sum = fansactivitygraph::where('event_id',$id)->get( array(
          DB::raw('SUM(actid1) as action1'),
          DB::raw('SUM(actid2) as action2'),
          DB::raw('SUM(actid3) as action3'),
          DB::raw('SUM(actid4) as action4'),
          DB::raw('SUM(actid5) as action5'),
          DB::raw('SUM(actid6) as action6'),
        ));
        $fanscount = fansactivitygraph::where('event_id',$id)->get()->count();
        $total_action = $sum[0]->action1 + $sum[0]->action2 + $sum[0]->action3 +$sum[0]->action4 + $sum[0]->action5 + $sum[0]->action6;
        if($fanscount > 0 ){
          $action_average = (int)ceil($total_action / $fanscount);
        }else{
          $action_average = 0;
        }
      return view('artistweb.eventhistorydetail',compact('eventHistory','action_average'));
      //return $event_history_data = app('App\Http\Controllers\API\EventController')->eventshowweb($id);
          
    }

 
  public function eventview(Request $request,$ids){
    
    // dd($id);
      $id = Crypt::decryptString($ids);
      $profile = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
      $profileArray = json_decode ($profile->content(), true);
      $a_profile = $profileArray['profile'];

      $sc_event = app('App\Http\Controllers\API\EventController')->eventshow($id);
      $sc_eventArray = json_decode ($sc_event->content(), true);
      $sc_event = $sc_eventArray['data'];

    return view('artistweb.eventDetail',compact('a_profile','sc_event'));
  }
}
