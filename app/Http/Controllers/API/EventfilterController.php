<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Artist_profiles;
use App\Models\Event;
use App\Models\Event_joined_by_fans;
use Carbon\Carbon;

class EventfilterController extends Controller
{
    public function eventFilter(Request $request)
    {
        if($request["type"] == 'events')
        {
            $eventName = $request["name"];
            $genre = $request["genre"];
            $eventrating = $request["rating"];
            
            $fromdate = $request["from_date"];
            // $fromdate1 = $request["from_date"];
            // $yesterday_date = date("Y-m-d", strtotime("yesterday"));
            // $from_date = date("Y-m-d", strtotime($fromdate1));
            // if($fromdate1 != NULL){
            //     if($from_date < $yesterday_date){
            //         $fromdate = $yesterday_date;
            //     }else{
            //         $fromdate = $request["from_date"];
            //     }
            // }else{
            //     $fromdate = NULL;
            // }
            
            $todate1 = $request["to_date"];
            $to_date = date("Y-m-d", strtotime($todate1));
            $current_date = date("Y-m-d");
            if($todate1 != NULL){
                if($to_date < $current_date){
                    $todate = $to_date;
                }else{
                    $todate = $request["to_date"];
                }
            }else{
                $todate = NULL;
            }
            
            // dd($fromdate,$todate);
            $genrevalue = [];
            if($genre != null){
                    foreach($genre as $value){
                        if($value !== NULL && $value !== FALSE && $value !== ""){
                            $genrevalue[]=$value;
                        }
                    }
                }
                $ratingvalue = [];
            if($eventrating != null){
                foreach($eventrating as $value){
                    if($value !== NULL && $value !== FALSE && $value !== ""){
                        $ratingvalue[]=$value;
                    }
                }
            }
                if(($eventName !== NULL && $eventName !== FALSE && $eventName !== "") || count($genrevalue) > 0 || count($ratingvalue) > 0 || $fromdate !== NULL || $todate !== NULL){
                    // dd('hi');
                $event = Event::with('Eventratings')->when(count($genrevalue) > 0,function($q) use($genrevalue){
                        $q->where(function($query) use ($genrevalue) {
                            $i = 0;
                            foreach ($genrevalue as $key => $value) {
                             if($i)
                             {
                                $query->orWhereRaw("find_in_set('$value',genre)");
                             }else{
                                $query->whereRaw("find_in_set('$value',genre)");
                             }
                             $i++;
                            }
                        });
                })->when($eventName,function($q) use($eventName){
                    $q->where("event_title",
                    "like",
                    "%" . $eventName . "%");
                })
                ->where(function($q) use($ratingvalue){
                    $i = 0;
                foreach ($ratingvalue as $key => $value) {
                 if($i)
                 {
                    $q->orWhereRaw("find_in_set('$value',ratings)");
                  
                 }else{
                    $q->whereRaw("find_in_set('$value',ratings)");
                 }
                 $i++;
                }
            })->when(($fromdate != NULL && $todate == NULL),function($q) use($fromdate){
                    $q->where("event_date",$fromdate);
                })->when(($todate != NULL && $fromdate == NULL),function($q) use($todate){
                    $q->where("event_date",$todate);
                })->when(($todate != NULL && $fromdate != NULL),function($q) use($todate,$fromdate){
                    $q->whereBetween('event_date', [$fromdate, $todate]);
                })->get();
                // dd($event);
                $data = [];
                foreach($event as $i => $value){
                    $data['events'][$i]['id'] = $value->id;
                    $data['events'][$i]['title'] = $value->event_title;
                    $data['events'][$i]['date'] = $value->event_date;
                    $data['events'][$i]['time'] = $value->event_time;
                    $data['events'][$i]['link_to_event_stream'] = $value->link_to_event_stream;
                    $data['events'][$i]['duration'] = $value->event_duration;
                    $eventimage = explode(',',$value->event_image);
                    $data['events'][$i]['image'] = url('').'/eventimages/'.$eventimage[0];
                    $data['events'][$i]['genre'] = $value->genre;
                    $data['events'][$i]['description'] = $value->event_description;
                    $data['events'][$i]['status'] = $value->event_status;
                    $data['events'][$i]['count'] = $value->event_count;
                    if($value->event_date == Carbon::today()){
                        $data['events'][$i]['livestatus'] = 1;
                    }else{
                        $data['events'][$i]['livestatus'] = 0;
                    }
                    // $data['events'][$i]['count'] = $value->event_count;
                }
                if($data){
                    $response = [
                        'status' => 200,
                        'success' => true,
                        'data'    => $data,
                        'message' => 'Event Details Filtered Succefully',
                    ];
                    return response()->json($response, 200); 
                }else{
                    $datas = (object)[
                        'events' => [
                        ],
                      ];
                    $response = [
                        'status' => 200,
                        'success' => false,
                        'message' => 'No Event Detail Found',
                        'data'    => $datas,
                    ];
                    return response()->json($response, 200);
                }
            }else{
                // dd('hlo');
                $events = Event::all();
                $data = [];
                foreach($events as $i => $value){
                    $data['events'][$i]['id'] = $value->id;
                    $data['events'][$i]['title'] = $value->event_title;
                    $data['events'][$i]['date'] = $value->event_date;
                    $data['events'][$i]['time'] = $value->event_time;
                    $data['events'][$i]['link_to_event_stream'] = $value->link_to_event_stream;
                    $data['events'][$i]['duration'] = $value->event_duration;
                    $eventimage = explode(',',$value->event_image);
                    $data['events'][$i]['image'] = url('').'/eventimages/'.$eventimage[0];
                    $data['events'][$i]['genre'] = $value->genre;
                    $data['events'][$i]['description'] = $value->event_description;
                    $data['events'][$i]['status'] = $value->event_status;
                    if($value->event_date == Carbon::today()){
                        $data['events'][$i]['livestatus'] = 1;
                    }else{
                        $data['events'][$i]['livestatus'] = 0;
                    }
                    $data['events'][$i]['count'] = $value->event_count;
                }
                if($data){
                    $response = [
                        'status' => 200,
                        'success' => true,
                        'message' => 'Events Retrived Successfully',
                        'data'    => $data,
                    ];
                    return response()->json($response, 200);
                }
            }
        }else{

            $response = [
                'status' => 400,
                'success' => false,
                'message' => $request["type"],
            ];
            return response()->json($response, 400);
        }
    }
}
