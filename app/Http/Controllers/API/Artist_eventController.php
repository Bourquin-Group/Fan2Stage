<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\User;
use App\Models\Event_joined_by_fans;

class Artist_eventController extends Controller
{
    public function artischeduleEvent(Request $request){
        // $authid = Auth::User()->id;
        $user = User::where('id',9)->where('user_type','artists')->first();
        $data = [];
        if($user){
            $scheduleevent = Event::where(['user_id'=> $user->id,'event_status'=>1])->where('deleted_at',Null)->get();
            foreach($scheduleevent as $i => $value){
                $data['schedule_event'][$i]['event_title'] = $value->event_title;
                $data['schedule_event'][$i]['date'] = $value->event_date;
                $data['schedule_event'][$i]['time'] = $value->event_time;
                $data['schedule_event'][$i]['link_to_event_stream'] = $value->link_to_event_stream;
                $data['schedule_event'][$i]['duration'] = $value->event_duration;
                $data['schedule_event'][$i]['image'] = url('').'/eventimages/'.$value->event_image;
                $data['schedule_event'][$i]['genre'] = $value->genre;
                $data['schedule_event'][$i]['description'] = $value->event_description;
                $data['schedule_event'][$i]['count'] = $value->event_count;
            }
            if($data){
                $response = [
                    'status'  => 200,
                    'success' => true,
                    'data'    => $data,
                    'message' => 'Schedule Event Data Retrived Successfully',
                ];
                return response()->json($response, 200);
            }else{
                $response = [
                    'status'  => 404,
                    'success' => false,
                    'message' => 'No Schedule Event Found',
                ];
                return response()->json($response, 404);
            }
            
        }else{
            $response = [
                'status'  => 204,
                'success' => false,
                'message' => 'No Artist Found',
            ];
            return response()->json($response, 204);
        }
    }
    public function liveEvent(Request $request){
        

        $user = User::where('id',$request->artist_id)->where('user_type','artists')->first();
        $data = [];
        if($user){
            // $currentTime = date('H:i:s');
            // $starttime = date('H:i:s',strtotime("-30 minutes",strtotime($currentTime)));
            
            $liveevent = Event::where(['user_id'=> $user->id,'event_status'=>1])->where('deleted_at',Null)->get();
            // $liveevent = Event::where(['user_id'=> $user->id,'event_status'=>1])->where('deleted_at',Null)->get();
            foreach($liveevent as $i => $value){
                // $eventTime = date('H:i:s',strtotime("-30 minutes",strtotime($value->event_time)));
                // if($starttime = $eventTime){
                // dd('hi');
                //  }else{
                //  dd('no');
                //  }
                $data['live_event'][$i]['event_title'] = $value->event_title;
                $data['live_event'][$i]['date'] = $value->event_date;
                $data['live_event'][$i]['time'] = $value->event_time;
                $data['live_event'][$i]['link_to_event_stream'] = $value->link_to_event_stream;
                $data['live_event'][$i]['duration'] = $value->event_duration;
                $data['live_event'][$i]['image'] = $value->event_image;
                $data['live_event'][$i]['genre'] = $value->genre;
                $data['live_event'][$i]['description'] = $value->event_description;
                $data['live_event'][$i]['count'] = $value->event_count;
            }
            if($data){
                $response = [
                    'status'  => 200,
                    'success' => true,
                    'data'    => $data,
                    'message' => 'Live Event Data Retrived Successfully',
                ];
                return response()->json($response, 200);
            }else{
                $response = [
                    'status'  => 204,
                    'success' => false,
                    'message' => 'No Live Event Found',
                ];
                return response()->json($response, 204);
            }
           
        }
        else{
            $response = [
                'status'  => 204,
                'success' => false,
                'message' => 'No Artist Found',
            ];
            return response()->json($response, 204);
        }
    }
    public function pastEvent(Request $request){
        // $authid = Auth::User()->id;
        $user = User::where('id',9)->where('user_type','artists')->first();
        $data = [];
        if($user){
            // $currentTime = date('H:i:s');
            // $starttime = date('H:i:s',strtotime("-30 minutes",strtotime($currentTime)));
            
            $pastevent = Event::where(['user_id'=> $user->id,'event_status'=>0])->where('deleted_at',Null)->get();
            // $pastevent = Event::where(['user_id'=> $user->id,'event_status'=>1])->where('deleted_at',Null)->get();
            foreach($pastevent as $i => $value){
                // $eventTime = date('H:i:s',strtotime("-30 minutes",strtotime($value->event_time)));
                // if($starttime = $eventTime){
                // dd('hi');
                //  }else{
                //  dd('no');
                //  }
                $data['past_event'][$i]['event_title'] = $value->event_title;
                $data['past_event'][$i]['date'] = $value->event_date;
                $data['past_event'][$i]['time'] = $value->event_time;
                $data['past_event'][$i]['link_to_event_stream'] = $value->link_to_event_stream;
                $data['past_event'][$i]['duration'] = $value->event_duration;
                $data['past_event'][$i]['image'] = $value->event_image;
                $data['past_event'][$i]['genre'] = $value->genre;
                $data['past_event'][$i]['description'] = $value->event_description;
                $data['past_event'][$i]['count'] = $value->event_count;
            }
            if($data){
                $response = [
                    'status'  => 200,
                    'success' => true,  
                    'data'    => $data,
                    'message' => 'past Event Data Retrived Successfully',
                ];
                return response()->json($response, 200);
            }else{
                $response = [
                    'status'  => 204,
                    'success' => false,
                    'message' => 'No past Event Found',
                ];
                return response()->json($response, 204);
            }
           
        }
        else{
            $response = [
                'status'  => 204,
                'success' => false,
                'message' => 'No Artist Found',
            ];
            return response()->json($response, 204);
        }
    }
}
