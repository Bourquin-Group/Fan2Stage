<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\User;
use App\Models\Event_joined_by_fans;
use App\Models\Eventbooking;
use App\Models\timezone;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;

class Fans_eventController extends Controller
{


    public function fansEvent(Request $request){
        $authid = Auth::user()->id;
        $user = User::where('id',$authid)->where('user_type','users')->first();
        $event_id = Eventbooking::where('user_id',$authid)->where('status',1)->pluck('event_id')->toArray();
        $fansevent = Event::whereIn('id',$event_id)->get();
        $upcomingEvent=[];
        $fanupcomingEvent = [];
        $pastEvent=[];
        $fanpastEvent = [];
        if(count($fansevent) > 0){
        foreach($fansevent as $value){
            if($value->event_status == 1 && $value->event_date >=Carbon::today()){
                $upcomingEvent['event_id'] = $value->id;
                $upcomingEvent['event_title'] = $value->event_title;
                $upcomingEvent['date'] = $value->event_date;
                $upcomingEvent['time'] = $value->event_time;
                $timezone_region = timezone::where('timezone',$value->event_timezone)->first();
                $upcomingEvent['event_timezone']=$timezone_region->region;
                $upcomingEvent['link_to_event_stream'] = $value->link_to_event_stream;
                $upcomingEvent['duration'] = $value->event_duration;
                $eventimage = explode(',',$value->event_image);
                $upcomingEvent['image'] = asset('/eventimages/'.$eventimage[0]);
                $upcomingEvent['genre'] = $value->genre;
                $upcomingEvent['description'] = $value->event_description;
                $upcomingEvent['event_plan_type'] = $value->event_plan_type;
                $upcomingEvent['count'] = $value->event_count;
                $upcomingEvent['event_status'] = $value->eventBooking->status;
                $fanupcomingEvent[] = $upcomingEvent;
            }
            if($value->event_status == 0){
                $pastEvent['event_id'] = $value->id;
                $pastEvent['event_title'] = $value->event_title;
                $pastEvent['date'] = $value->event_date;
                $pastEvent['time'] = $value->event_time;
                $timezone_region = timezone::where('timezone',$value->event_timezone)->first();
                $pastEvent['event_timezone']=$timezone_region->region;
                $pastEvent['link_to_event_stream'] = $value->link_to_event_stream;
                $pastEvent['duration'] = $value->event_duration;
                $eventimage = explode(',',$value->event_image);
                $pastEvent['image'] = asset('/eventimages/'.$eventimage[0]);
                $pastEvent['genre'] = $value->genre;
                $pastEvent['description'] = $value->event_description;
                $pastEvent['event_plan_type'] = $value->event_plan_type;
                $pastEvent['count'] = $value->event_count;
                $pastEvent['event_status'] = $value->eventBooking->status;
                $eventreview = Eventbooking::where('user_id',$authid)->where('event_id',$value->id)->first();
                $pastEvent['eventreviewstatus'] = $eventreview->eventreviewstatus;
                $fanpastEvent[] = $pastEvent;
            }
        }
        $response = [
            'status'    =>200,
            'success'        => true,
            'message'           => 'Fans Event Retrived Successfully',
            'past_event'     => $fanpastEvent,
            'upcoming_event' => $fanupcomingEvent,
        ];
        return response()->json($response, 200);   
    }else{
        $response = [
            'status'  => 200,
            'success' => true,
            'message' => 'No Fans Event Found',
            'past_event'     => $fanpastEvent,
            'upcoming_event' => $fanupcomingEvent,
        ];
        return response()->json($response, 200);
    } 

    }
    public function fansEventApi(Request $request){
        $authid = Auth::user()->id;
        $user = User::where('id',$authid)->where('user_type','users')->first();
        $event_id = Eventbooking::where('user_id',$authid)->where('status',1)->pluck('event_id')->toArray();
        $fansevent = Event::whereIn('id',$event_id)->get();
        $upcomingEvent=[];
        $fanupcomingEvent = [];
        $pastEvent=[];
        $fanpastEvent = [];
        if(count($fansevent) > 0){
        foreach($fansevent as $value){
            if($value->event_status == 1 && $value->event_date >=Carbon::today()){
                $upcomingEvent['event_id'] = $value->id;
                $upcomingEvent['event_title'] = $value->event_title;
                $upcomingEvent['date'] = $value->event_date;
                $timezone_region = timezone::where('timezone',Auth::user()->timezone)->first();
                $eventdate = date('Y-m-d',strtotime($value->event_date));
                $eventtime = $value->event_time ;
                $eventdatetime = $eventdate.' '.$eventtime;       
                
                $timezone_region1 = timezone::where('timezone',$value->event_timezone)->first();
                
                $date = new DateTime($eventdatetime, new DateTimeZone($timezone_region1->region));

                $date->setTimezone(new DateTimeZone($timezone_region->region));
                $resultdatefrom = $date->format('h:i A');

                $minutesToAdd = $value->event_duration; // Change this to your desired duration

                // Add the minutes to the DateTime object
                $date->modify("+{$minutesToAdd} minutes");

                // Format the modified DateTime to the desired output
                $resultdateto = $date->format('h:i A');
                $upcomingEvent['time'] = $resultdatefrom;
                $upcomingEvent['link_to_event_stream'] = $value->link_to_event_stream;
                $upcomingEvent['duration'] = $value->event_duration;
                $eventimage = explode(',',$value->event_image);
                $upcomingEvent['image'] = asset('/eventimages/'.$eventimage[0]);
                $upcomingEvent['genre'] = $value->genre;
                $upcomingEvent['description'] = $value->event_description;
                $upcomingEvent['event_plan_type'] = $value->event_plan_type;
                $upcomingEvent['count'] = $value->event_count;
                $upcomingEvent['event_status'] = $value->eventBooking->status;
                $fanupcomingEvent[] = $upcomingEvent;
            }
            if($value->event_status == 0){
                $pastEvent['event_id'] = $value->id;
                $pastEvent['event_title'] = $value->event_title;
                $pastEvent['date'] = $value->event_date;
                $timezone_region = timezone::where('timezone',Auth::user()->timezone)->first();
                $eventdate = date('Y-m-d',strtotime($value->event_date));
                $eventtime = $value->event_time ;
                $eventdatetime = $eventdate.' '.$eventtime;       
                
                $timezone_region1 = timezone::where('timezone',$value->event_timezone)->first();
                
                $date = new DateTime($eventdatetime, new DateTimeZone($timezone_region1->region));

                $date->setTimezone(new DateTimeZone($timezone_region->region));
                $resultdatefrom = $date->format('h:i A');

                $minutesToAdd = $value->event_duration; // Change this to your desired duration

                // Add the minutes to the DateTime object
                $date->modify("+{$minutesToAdd} minutes");

                // Format the modified DateTime to the desired output
                $resultdateto = $date->format('h:i A');
                $pastEvent['time'] = $resultdatefrom;
                $pastEvent['link_to_event_stream'] = $value->link_to_event_stream;
                $pastEvent['duration'] = $value->event_duration;
                $eventimage = explode(',',$value->event_image);
                $pastEvent['image'] = asset('/eventimages/'.$eventimage[0]);
                $pastEvent['genre'] = $value->genre;
                $pastEvent['description'] = $value->event_description;
                $pastEvent['event_plan_type'] = $value->event_plan_type;
                $pastEvent['count'] = $value->event_count;
                $pastEvent['event_status'] = $value->eventBooking->status;
                $eventreview = Eventbooking::where('user_id',$authid)->where('event_id',$value->id)->first();
                $pastEvent['eventreviewstatus'] = $eventreview->eventreviewstatus;
                $fanpastEvent[] = $pastEvent;
            }
        }
        $response = [
            'status'    =>200,
            'success'        => true,
            'message'           => 'Fans Event Retrived Successfully',
            'past_event'     => $fanpastEvent,
            'upcoming_event' => $fanupcomingEvent,
        ];
        return response()->json($response, 200);   
    }else{
        $response = [
            'status'  => 200,
            'success' => true,
            'message' => 'No Fans Event Found',
            'past_event'     => $fanpastEvent,
            'upcoming_event' => $fanupcomingEvent,
        ];
        return response()->json($response, 200);
    } 

    }
    public function pastEvent(Request $request){
        

        $user = User::where('id',$request->user_id)->where('user_type','users')->first();
        $data = [];
        if($user){
            $pastevent = Event::where(['user_id'=> $user->id,'event_status'=>0])->where('deleted_at',Null)->get();
            foreach($pastevent as $i => $value){
                $data['schedule_event'][$i]['event_title'] = $value->event_title;
                $data['schedule_event'][$i]['date'] = $value->event_date;
                $data['schedule_event'][$i]['time'] = $value->event_time;
                $data['schedule_event'][$i]['link_to_event_stream'] = $value->link_to_event_stream;
                $data['schedule_event'][$i]['duration'] = $value->event_duration;
                $data['schedule_event'][$i]['image'] = $value->event_image;
                $data['schedule_event'][$i]['genre'] = $value->genre;
                $data['schedule_event'][$i]['description'] = $value->event_description;
                $data['schedule_event'][$i]['count'] = $value->event_count;
            }
            if($data){
                $response = [
                    'status'  => 200,
                    'success' => true,
                    'data'    => $data,
                    'message' => 'Past Event Data Retrived Successfully',
                ];
                return response()->json($response, 200);
            }else{
                $response = [
                    'status'  => 404,
                    'success' => false,
                    'message' => 'No Past Event Found',
                ];
                return response()->json($response, 404);
            }
            
        }else{
            $response = [
                'status'  => 404,
                'success' => false,
                'message' => 'No User Found',
            ];
            return response()->json($response, 404);
        }
    }
    public function upcomingEvent(Request $request){
        

        $user = User::where('id',$request->user_id)->where('user_type','users')->first();
        $data = [];
        if($user){
            $scheduleevent = Event::where(['user_id'=> $user->id,'event_status'=>1])->where('deleted_at',Null)->get();
            foreach($scheduleevent as $i => $value){
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
                    'message' => 'Upcoming Event Data Retrived Successfully',
                ];
                return response()->json($response, 200);
            }else{
                $response = [
                    'status'  => 404,
                    'success' => false,
                    'message' => 'No Upcoming Event Found',
                ];
                return response()->json($response, 404);
            }
           
        }
        else{
            $response = [
                'status'  => 404,
                'success' => false,
                'message' => 'No User Found',
            ];
            return response()->json($response, 404);
        }
    }

    public function filterpastEvent(Request $request){
        $authid = Auth::User()->id;
        $event_id = Eventbooking::where('user_id',$authid)->pluck('event_id')->toArray();
        $eventName = $request["title"];
        $genre = $request["genre"];
        $genrevalue = [];
        foreach($genre as $value){
            if($value !== NULL && $value !== FALSE && $value !== ""){
                $genrevalue[]=$value;
            }
        }
                $event = Event::when(count($genrevalue) > 0,function($q) use($genrevalue){
                        $q->whereIn('genre',$genrevalue);
                    })->when($eventName,function($q) use($eventName){
                        $q->where('event_title',"like",
                        "%" . $eventName . "%");
                    })->whereIn('id',$event_id)->where(['event_status'=>0])->where('deleted_at',Null)->get();
                $data = [];
                foreach($event as $i => $value){
                    $data['events'][$i]['id'] = $value->id;
                    $data['events'][$i]['title'] = $value->event_title;
                    $data['events'][$i]['date'] = $value->event_date;
                    $data['events'][$i]['time'] = $value->event_time;
                    $data['events'][$i]['link_to_event_stream'] = $value->link_to_event_stream;
                    $data['events'][$i]['duration'] = $value->event_duration;
                    $data['events'][$i]['image'] = url('').'/eventimages/'.$value->event_image;
                    $data['events'][$i]['genre'] = $value->genre;
                    $data['events'][$i]['description'] = $value->event_description;
                    $data['events'][$i]['count'] = $value->event_count;
                }
            if($data){
                $response = [
                    'status' => 200,
                    'success' => true,
                    'data'    => $data,
                    'message' => 'Past Event Filtered Succefully',
                ];
                return response()->json($response, 200); 
            }else{
                $response = [
                    'status' => 404,
                    'success' => false,
                    'data'    => $data,
                    'message' => 'No Past Event Detail Found',
                ];
                return response()->json($response, 404);
            }
        }

        public function filterupcomingevent(Request $request){
            $authid = Auth::User()->id;
            $event_id = Eventbooking::where('user_id',$authid)->pluck('event_id')->toArray();
            $eventName = $request["title"];
                $genre = $request["genre"];
                $genrevalue = [];
                    foreach($genre as $value){
                        if($value !== NULL && $value !== FALSE && $value !== ""){
                            $genrevalue[]=$value;
                        }
                    }
                    $event = Event::when(count($genrevalue) > 0,function($q) use($genrevalue){
                            $q->whereIn('genre',$genrevalue);
                        })->when($eventName,function($q) use($eventName){
                            $q->where('event_title',"like",
                            "%" . $eventName . "%");
                        })->whereIn('id',$event_id)->where(['event_status'=>1])->where('deleted_at',Null)->get();
                    $data = [];
                    foreach($event as $i => $value){
                        $data['events'][$i]['id'] = $value->id;
                        $data['events'][$i]['title'] = $value->event_title;
                        $data['events'][$i]['date'] = $value->event_date;
                        $data['events'][$i]['time'] = $value->event_time;
                        $data['events'][$i]['link_to_event_stream'] = $value->link_to_event_stream;
                        $data['events'][$i]['duration'] = $value->event_duration;
                        $data['events'][$i]['image'] = url('').'/eventimages/'.$value->event_image;
                        $data['events'][$i]['genre'] = $value->genre;
                        $data['events'][$i]['description'] = $value->event_description;
                        $data['events'][$i]['count'] = $value->event_count;
                    }
                if($data){
                    $response = [
                        'status' => 200,
                        'success' => true,
                        'data'    => $data,
                        'message' => 'Past Event Filtered Succefully',
                    ];
                    return response()->json($response, 200); 
                }else{
                    $response = [
                        'status' => 404,
                        'success' => false,
                        'data'    => $data,
                        'message' => 'No Past Event Detail Found',
                    ];
                    return response()->json($response, 404);
                }
            }
}
