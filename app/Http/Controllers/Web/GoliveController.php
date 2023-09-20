<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;
use App\Models\Livecount;
use App\Models\Eventbooking;
use Response;
// use Redis;
use Illuminate\Support\Facades\Redis;
use Client;

class GoliveController extends Controller
{
   public function livefancount(Request $request,$id){
       $livecount = app('App\Http\Controllers\API\GoliveController')->livecount($id);
       
       $livecountArray = json_decode ($livecount->content(), true);
       $event = $livecountArray['livecount'];

       $booked = Eventbooking::where('event_id',$id)->where('status',1)->count();

     return Response::json(array(
        'success' => true,
        'livecount'   => $event,
        'bookedcount'   => $booked
    )); 
   }
   public function actiongraphcount1(Request $request,$id){
    $livecount = app('App\Http\Controllers\API\GoliveController')->artistactiongraphcount($id);
    $livecountArray = json_decode ($livecount->content(), true);
     return Response::json(array(
        'success' => true,
        'act1' => $livecountArray['act1'],
        'act2' => $livecountArray['act2'],
        'act3' => $livecountArray['act3'],
        'act4' => $livecountArray['act4'],
        'act5' => $livecountArray['act5'],
        'act6' => $livecountArray['act6'],
        'actt1' => $livecountArray['actt1'],
        'actt2' => $livecountArray['actt2'],
        'actt3' => $livecountArray['actt3'],
        'actt4' => $livecountArray['actt4'],
        'actt5' => $livecountArray['actt5'],
        'actt6' => $livecountArray['actt6'],
    )); 
}
    public function livefanactioncount(Request $request,$id){
        // $eventsid =base64_decode($id);
        $liveevent = app('App\Http\Controllers\API\GoliveController')->livefanactioncount($id);
        $liveeventArray = json_decode ($liveevent->content(), true);
         $event = $liveeventArray['success'];
        if($event == true){
            return Response::json(array(
                'success' => true,
                'message'   => $liveeventArray['message']
            ));
        }
    }
    public function fansactivitysummary(Request $request,$id){
        $liveevent = app('App\Http\Controllers\API\GoliveController')->fansactivitysummary($id);
        $liveeventArray = json_decode ($liveevent->content(), true);
         $event = $liveeventArray['success'];
        if($event == true){
            return Response::json(array(
                'success' => true,
                'actid1'   => $liveeventArray['actid1'],
                'actid2'   => $liveeventArray['actid2'],
                'actid3'   => $liveeventArray['actid3'],
                'actid4'   => $liveeventArray['actid4'],
                'actid5'   => $liveeventArray['actid5'],
                'actid6'   => $liveeventArray['actid6'],
            ));
        }
    }

    public function exitliveevent(Request $request,$id){
        $event_id =base64_decode($id);

        if($event_id){
            $keys = Redis::keys('FansCounts:'.$event_id);
            $user_count = [];
            foreach ($keys as $key) {
            $stored = Redis::hgetall($key);
            $user_count[] = $stored ;
            }
            $countvalue = $user_count[0]['eventcount'] - 1;

            Redis::hmset('FansCounts:'.$event_id,[
                'eventid' => $event_id,
                'eventcount' => $countvalue,
                'updatedat' => Carbon::now(),
                ]);
            $live = Eventbooking::where('event_id', $event_id)->where('user_id',auth()->user()->id)->first();
            $live->exitEvent_Time = Carbon::now();
            $live->save();
        }
        return redirect()->route('live-event', base64_encode($event_id));
    }
}
