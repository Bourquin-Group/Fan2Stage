<?php

namespace App\Http\Controllers\Fan;

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
    public function checklive(Request $request){
        // $eventsid =base64_decode($id);
        $eventsid =$request->id;
        $liveevent = app('App\Http\Controllers\API\GoliveController')->checklive($eventsid);
        $liveeventArray = json_decode ($liveevent->content(), true);
         $status = $liveeventArray['event_states'];
         if($status == true){
            return response()->json([
                'success' => true,
            	'flag' => 1,
                'event_id' => $eventsid,
            ]);
          }else{
            return response()->json([
                'success' => false,
            	'flag' => 0,
                'message' => "Event has been Finished",
            ]);
          }
    }
    public function golive(Request $request,$id){
        // $eventsid =base64_decode($id);
        $eventsid =$id;
        $liveevent = app('App\Http\Controllers\API\GoliveController')->golive($eventsid);
        $liveeventArray = json_decode ($liveevent->content(), true);
         $event = $liveeventArray['data'];
        if($event){
            return view('fanweb.golive',compact('event'));
        }
    }
    public function checkjoinevent(Request $request){
        // $eventsid =$id;
        $joinevent = app('App\Http\Controllers\API\EventbookingController')->checkjoinevent($request);
        $joineventArray = json_decode ($joinevent->content(), true);
         $status = $joineventArray['success'];
         if($status == true){
            $id =base64_encode($request->event_id);
            return response()->json([
                'success' => true,
                'event_id' => $id,
            ]);
          }else{
            return response()->json([
                'success' => false,
                'message' => $joineventArray['message'],
            ]);
          }
    }
    public function livecount(Request $request,$id){
        $livecount = app('App\Http\Controllers\API\GoliveController')->livecount($id);
        $livecountArray = json_decode ($livecount->content(), true);
         $event = $livecountArray['livecount'];
         $endevent = $livecountArray['checkendlive'];

        // $checkendlive = app('App\Http\Controllers\API\GoliveController')->checkendevent($id);
        // $checkendliveArray = json_decode ($checkendlive->content(), true);
        //  $endevent = $checkendliveArray['checkendlive'];
         if($endevent == 1){
            $endeventstatus = true;
        }else{
             $endeventstatus = false;
         }

         return Response::json(array(
            'success' => true,
            'livecount'   => $event,
            'endlive'   => $endeventstatus
        )); 
    }
    public function actioncount(Request $request){
        // $eventsid =base64_decode($id);
        $liveevent = app('App\Http\Controllers\API\GoliveController')->actioncount($request);
        $liveeventArray = json_decode ($liveevent->content(), true);
         $event = $liveeventArray['success'];
        if($event == true){
            return Response::json(array(
                'success' => true,
                'message'   => $liveeventArray['message']
            ));
        }
    }
    public function actiongraphcount(Request $request,$id){

        $livecount = app('App\Http\Controllers\API\GoliveController')->actiongraphcount($id);
        $livecountArray = json_decode ($livecount->content(), true);
         $act1 = $livecountArray['act1'];

         return Response::json(array(
            'success' => true,
            'act1' => $livecountArray['act1'],
            'act2' => $livecountArray['act2'],
            'act3' => $livecountArray['act3'],
            'act4' => $livecountArray['act4'],
            'act5' => $livecountArray['act5'],
            'act6' => $livecountArray['act6'],
        )); 
    }
    public function totalactioncount(Request $request,$id){

        $livecount = app('App\Http\Controllers\API\GoliveController')->totalactioncount($id);
        $livecountArray = json_decode ($livecount->content(), true);
         $act1 = $livecountArray['act1'];

         return Response::json(array(
            'success' => true,
            'act1' => $livecountArray['act1'],
            'act2' => $livecountArray['act2'],
            'act3' => $livecountArray['act3'],
            'act4' => $livecountArray['act4'],
            'act5' => $livecountArray['act5'],
            'act6' => $livecountArray['act6'],
        )); 
    }

    public function exitliveevent(Request $request){
        $review = app('App\Http\Controllers\API\EventbookingController')->exitEvent($request);
        $reviewArray = json_decode ($review->content(), true);
        $va = $reviewArray['success'];
        if($va == 'true'){
            return response()->json(['event_id' => $reviewArray['event_id'], 'message' => $reviewArray['message'], 'tipflag' => $reviewArray['tipflag'], 'tipamount' => $reviewArray['tipamount'], 'event_id' => $reviewArray['event_id']]);
          }else{
            return response()->json(['status' => 0, 'message' => $reviewArray['error']]);
          }
        
    }
    public function exitliveeventapi(Request $request){
        $review = app('App\Http\Controllers\API\EventbookingController')->exiteventapi($request);
        $reviewArray = json_decode ($review->content(), true);
        $va = $reviewArray['success'];
        if($va == 'true'){
            return response()->json(['event_id' => $reviewArray['event_id'], 'message' => $reviewArray['message'], 'event_id' => $reviewArray['event_id']]);
          }else{
            return response()->json(['status' => 0, 'message' => $reviewArray['error']]);
          }
        
    }
}
