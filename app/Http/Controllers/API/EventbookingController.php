<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Event;
use App\Models\Eventbooking;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event_joined_by_fans;
use App\Models\subscriptionplan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Artist_profiles;
use Carbon\Carbon;

class EventbookingController extends Controller
{
    public function Eventbooking(Request $request){

        // try{
            $input = $request->all();
        $validator = Validator::make($input, [
            'artist_id' => 'required',
            'event_id' => 'required',
            'amount' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Invalid params passed',
                'errors' => $validator->errors()
            ], 400);       
        }

    $artistid = $request->artist_id;
    $event_id = $request->event_id;
    $usertype = User::where('id',$artistid)->where('user_type','artists')->first();
    $planid = $usertype->subscription_plan_id;
    $f2splan = subscriptionplan::where('id',$planid)->first();
    $fans_per_event = $f2splan->fans_per_event;
    $eventStatus = Event::where(['id' => $event_id,'event_status' => 1])->first();
    if($eventStatus){
        $user_count = Eventbooking::where('artist_id',$artistid)->where('event_id',$event_id)->where('status',1)->pluck('user_id')->toArray();
        if(count($user_count) < $fans_per_event){
                $inputs = [ 
                    'artist_id' => $request->artist_id,
                    'event_id' => $request->event_id,
                    'amount' => $request->amount,
                    'payment_status' => 1,
                    'status' => 1,
                    'user_id' => auth()->user()->id
                ];
                $eventStatus = Eventbooking::where(['event_id' => $event_id,'artist_id' => $artistid,'status'=> 1,'user_id' => auth()->user()->id])->first();
                if($eventStatus){
                    $response = [
                        'status' => 208,
                        'success'   => false,
                        'message' => 'Event Has Been Booked Already',
                    ];
                    return response()->json($response, 208);
                }else{
                    $Event = Eventbooking::create($inputs);
                    if($Event){
                    $response = [
                        'status' => 200,
                        'success'   => true,
                        'bookig_status' => true,
                        'message' => 'Event Booked Successfully',
                    ];
                    return response()->json($response, 200);
                    }else{
                        $response = [
                            'status' => 409,
                            'success'   => true,
                            'bookig_status' => false,
                            'message' => 'Event Not Booked Successfully',
                        ];
                        return response()->json($response, 409);
                    }
                }
            }else{
                $response = [
                    'status' => 403,
                    'success'   => true,
                    'bookig_status' => false,
                    'message' => 'Booking For This Event Is Full',
                ];
                return response()->json($response, 403);
            }
        }else{
            $response = [
                'success'   => true,
                'bookig_status' => false,
                'message' => 'Event Has Been Done Already',
            ];
            return response()->json($response, 200);
        }

        // }catch(\Exception $e){

        //     dd('message',$e->getMessage());
        // }
        
    }
    public function bookingevents($id){
        $events = Eventbooking::where('user_id',$id)->get();
            foreach($events as $i => $value){
                $data['events'][$i]['id'] = $value->id;
                $name = Event::where('id',$value->event_id)->first();
                $data['events'][$i]['title'] = $name->event_title;
                $data['events'][$i]['date'] = $value->amount;
                $data['events'][$i]['time'] = $value->status;
            }
            if($data){
        $response = [
            'success' => true,
            'message' => 'Booking Event Retrived Successfully',
            'data'    => $data,
        ];
        return response()->json($response, 200);
        }else{
            $response = [
                'success' => false,
                'message' => 'No Booking Event Found',
                'data'    => $data,
            ];
            return response()->json($response, 404);
        }
    }
    public function cancelbooking($id)
    {
        $eventbooking = Eventbooking::where('user_id',Auth::user()->id)->where('event_id',$id)->where('status',1)->first();
        if($eventbooking){
            $eventbooking->status = 0;
            $eventbooking->save();
            Notification::create(['event_booking_id' => $eventbooking->id, 'type' =>4, 'user_id' => auth()->user()->id]);
           
            // $event->delete();
            return response()->json([
                'status' => 200,
                'success' => true,
                'booking-status' => true,
                'message' => 'Event Booking Cancelled Successfully',
            ]);
        }
        else{
            return response()->json([
                'status' => 208,
                'success' => true,
                'booking-status' => false,
                'message' => 'Event Booking has been already cancelled',
            ]);
        }
    }
    public function cancelbookingweb(Request $request)
    {
        $id = $request->event_id;
        $eventbooking = Eventbooking::where('user_id',Auth::user()->id)->where('event_id',$id)->where('status',1)->first();
        if($eventbooking){
            $eventbooking->status = 0;
            $eventbooking->save();
            Notification::create(['event_booking_id' => $eventbooking->id, 'type' =>4, 'user_id' => auth()->user()->id]);
           
            // $event->delete();
            return response()->json([
                'status' => 200,
                'success' => true,
                'booking-status' => true,
                'message' => 'Event Booking Cancelled Successfully',
            ]);
        }
        else{
            return response()->json([
                'status' => 208,
                'success' => true,
                'booking-status' => false,
                'message' => 'Event Booking has been already cancelled',
            ]);
        }
    }

    public function bookingeventFilter(Request $request){
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
        if(($eventName !== NULL && $eventName !== FALSE && $eventName !== "") || count($genrevalue) > 0){
                $event = Event::when(count($genrevalue) > 0,function($q) use($genrevalue){
                        $q->whereIn('genre',$genrevalue);
                    })->when($eventName,function($q) use($eventName){
                        $q->where('event_title',$eventName);
                    })->whereIn('id',$event_id)->where(['event_status'=>0])->where('deleted_at',Null)->get();
                $data = [];
                foreach($event as $i => $value){
                    $data['events'][$i]['id'] = $value->id;
                    $data['events'][$i]['title'] = $value->event_title;
                    $data['events'][$i]['date'] = $value->event_date;
                    $data['events'][$i]['time'] = $value->event_time;
                    $data['events'][$i]['link_to_event_stream'] = $value->link_to_event_stream;
                    $data['events'][$i]['duration'] = $value->event_duration;
                    $data['events'][$i]['image'] = $value->event_image;
                    $data['events'][$i]['genre'] = $value->genre;
                    $data['events'][$i]['description'] = $value->event_description;
                    $data['events'][$i]['count'] = $value->event_count;
                }
            if($data){
                $response = [
                    'status' => 200,
                    'success' => true,
                    'data'    => $data,
                    'message' => 'Booking Event Filtered Succefully',
                ];
                return response()->json($response, 200); 
            }else{
                $response = [
                    'status' => 404,
                    'success' => false,
                    'message' => 'No Booking Event Detail Found',
                ];
                return response()->json($response, 404);
            }
        }else{
            $authid = Auth::User()->id;
            $event_id = Eventbooking::where('user_id',$authid)->pluck('event_id')->toArray();
            $event = Event::whereIn('id',$event_id)->where(['event_status'=>0])->where('deleted_at',Null)->get();
            $data = [];
            foreach($event as $i => $value){
                $data['events'][$i]['id'] = $value->id;
                $data['events'][$i]['title'] = $value->event_title;
                $data['events'][$i]['date'] = $value->event_date;
                $data['events'][$i]['time'] = $value->event_time;
                $data['events'][$i]['link_to_event_stream'] = $value->link_to_event_stream;
                $data['events'][$i]['duration'] = $value->event_duration;
                $data['events'][$i]['image'] = $value->event_image;
                $data['events'][$i]['genre'] = $value->genre;
                $data['events'][$i]['description'] = $value->event_description;
                $data['events'][$i]['count'] = $value->event_count;
            }
        if($data){
            $response = [
                'status' => 200,
                'success' => true,
                'data'    => $data,
                'message' => 'Booking Event Filtered Succefully',
            ];
            return response()->json($response, 200); 
            }
        }
    }
    public function joinEvent(Request $request){
        $input = $request->all();
            $validator = Validator::make($input, [
                'event_id' => 'required',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'message' => 'Invalid params passed',
                    'errors' => $validator->errors()
                ], 403);       
            }
            $eventid = $request->event_id;
            $eventStatus = Event::where(['id' => $eventid,'event_status' => 1])->first();
            if($eventStatus){
                $authid = Auth::User()->id;
                $check_join = Eventbooking::where([
                                'user_id' => $authid,
                                'event_id' => $eventid,
                                'event_status' => 1
                                ])->first();
                if($check_join){
                    return response()->json([
                        'status'   => 200,
                        'success' => false,
                        'message' => 'You Have Already Joined',
                    ]);
                }
                $booking_id = Eventbooking::where([
                                'user_id' => $authid,
                                'event_id' => $eventid
                                ])->first();
                if($booking_id){
                        $booking_id->event_status = 1;
                        $booking_id->joinEvent_Time = Carbon::now();
                        $booking_id->exitEvent_Time = Null;
                        $booking_id->save();
                        return response()->json([
                            'status'   => 200,
                            'success' => true,
                            'message' => 'Successfully Joined',
                        ]);
                    } 
                }else{
                    return response()->json([
                        'status'   => 404,
                        'success' => false,
                        'message' => 'Event Has Been Already Done',
                    ]);
                }               

    }
    public function exitEvent(Request $request){
        $input = $request->all();
        // ----------------------------------------------------------------




        // $validation = [
        //     // 'rating' => 'required',
        //     'event_review'=>'required',
            
        // ];
        // if($request->rating < 3 || $request->rating == NULL){
        //     $rating_validation = [ 'rating' => 'required|min:3'];
        //     $validation = array_merge($validation, $rating_validation);
        // }
        // $validator = $this->validate($request,$validation,
        // [
        //     'rating.required'=> 'Please give your ratings',
        //     'rating.min'=> 'Please provide above 2 ratings',
        //     'event_review.required'=> 'Please give your reviews',
            
        // ]
        // );
        if($request->rating < 0 || $request->rating == NULL){
            $validator =Validator::make($request->all(),[
                'rating' => 'required|min:1',
            'event_review'=>'required',
        ],
        [
            'rating.required'=> 'Please give your ratings',
            'rating.min'=> 'Please provide minimum one ratings',
            'event_review.required'=> 'Please give your reviews',
            ]
        );  
        }else{
            $validator =Validator::make($request->all(),[
            'event_review'=>'required',
        ],
        [
            'event_review.required'=> 'Please give your reviews',
            ]
        );  
        }
        
        if($validator->fails()){
            return response()->json(['success' => false, 'error' => $validator->errors()->toArray()]);
        }
        // ----------------------------------------------------------------
            $ratings = $request->rating;
            $eventid = $request->event_id;
            $authid = Auth::User()->id;
            $booking_id = Eventbooking::where([
                            'user_id' => $authid,
                            'event_id' => $eventid
                            ])->first();
                            $artistid = Event::where(['id' => $eventid])->first();
                            $inputs = [ 
                                'artist_id' => $artistid->user_id,
                                'event_id' => $eventid,
                                'event_review' => $request->event_review,
                                'ratings' => $request->rating,
                                'user_id' => $authid
                            ];
                                $Event = Event_joined_by_fans::create($inputs);
                                // ratings
                                $review =Event_joined_by_fans::where('event_id',$eventid)->get();
                                $raiting = 0;
                                if($review->isNotEmpty())
                                {
                                    $raiting = $review->sum('ratings')/$review->count();
                                }
                                $checkevent = Event::where('id',$eventid)->first();
                                if($checkevent){
                                    $checkevent->ratings = floor($raiting);
                                    $checkevent->save();
                                }
                                $checkartist = Artist_profiles::where('user_id',$artistid->user_id)->first();
                                if($checkartist){
                                    $checkartist->ratings = floor($raiting);
                                    $checkartist->save();
                                }
                                // ratings
            $tips = $request->tips;
            if($tips !=null){
                $tip_flag=1;
                $tip_amount = $request->tips;
            }else{
                $tip_flag=0;
                $tip_amount = 0;
            }

            if($Event && $booking_id){
                    $booking_id->event_status = 0;
                    $booking_id->eventreviewstatus = 1;
                    $booking_id->joinEvent_Time = null;
                    $booking_id->exitEvent_Time = Carbon::now();
                    $booking_id->save();
                    return response()->json([
                        'status'   => 200,  
                        'success' => true,
                        'event_id' =>$eventid,
                        'tipflag' =>$tip_flag,
                        'tipamount' =>$tip_amount,
                        'message' => 'Successfully Exit From The Event',
                    ]);
                }
    }
    public function exiteventapi(Request $request){
        $booking_id = Eventbooking::where('event_id',$request->eventid)->where('user_id',Auth::user()->id)->first();
        if($booking_id){
            $booking_id->event_status = 0;
                    $booking_id->eventreviewstatus = 0;
                    $booking_id->joinEvent_Time = null;
                    $booking_id->exitEvent_Time = Carbon::now();
                    $booking_id->save();
                    return response()->json([
                        'status'   => 200,  
                        'success' => true,
                        'event_id' =>$request->eventid,
                        'message' => 'Successfully Exit From The Event',
                    ]);
        }else{
            return response()->json([
                'status'   => 409,  
                'success' => false,
                'event_id' =>$request->eventid,
                'message' => 'Event not exit successfully',
            ]);
        }
    }

    public function checkjoinevent(Request $request){
        $id=$request->event_id;

      $event = Event::where('id',$id)->where('event_status',1)->first();

      $eventstarttime = date("H:i A", strtotime($event->event_time));

      $current_time = date('H:i A');
    //   dd($eventstarttime,$current_time);
      if($current_time >= $eventstarttime){
        return response()->json([
          'success' => true,
          'event_id' => $id,
      ]);
      }else{
        return response()->json([
          'success' => false,
          'message' => 'You cannot join this event now!',
      ]);
      }

    }
    public function freebookevent($id){
        // $id = base64_decode($id);
        $event = Event::where('id',$id)->where('event_status',1)->first();
        if($event){
            $Event = Eventbooking::where('event_id',$id)->first();
        if($Event){
            $Event->status = 1;
            $Event->save();
        }else{
            $inputs = [ 
                'artist_id' => $event->user_id,
                'event_id' => $id,
                'amount' => 0,
                'payment_status' => 1,
                'status' => 1,
                'user_id' => auth()->user()->id
            ];
            $Event = Eventbooking::create($inputs);
        }
            if($Event){
                $response = [
                    'status' => 200,
                    'success'   => true,
                    'bookig_status' => true,
                    'message' => 'Event Booked Successfully',
                ];
                return response()->json($response, 200);
            }else{
                $response = [
                    'status' => 409,
                    'success'   => true,
                    'bookig_status' => false,
                    'message' => 'Event Not Booked Successfully',
                ];
                return response()->json($response, 409);
            }
        }else{
            $response = [
                'status' => 400,
                'success'   => true,
                'bookig_status' => false,
                'message' => 'Event Not Found',
            ];
            return response()->json($response, 400);
        }
    }

    public function checkprebooking(Request $request){
        $id = $request->id;
        
        $event = Event::where('id', $id)->where('event_status', 1)->first();

        $eventStartTime = $event->event_time;
        $eventEndTime = $event->event_closetime;
        $eventDate = $event->event_date;
        
        $bookings = Eventbooking::whereHas('eventDetail', function ($query) use ($eventStartTime, $eventEndTime, $eventDate) {
            $query->where('event_date', $eventDate)
                ->where(function ($subQuery) use ($eventStartTime, $eventEndTime) {
                    $subQuery->whereBetween('event_time', [$eventStartTime, $eventEndTime])
                        ->orWhereBetween('event_closetime', [$eventStartTime, $eventEndTime]);
                });
        })
        ->where('user_id', Auth::user()->id)
         ->where('status', 1)
        ->get();
       
        if ($bookings->isEmpty()) {
            $response = [
                'status' => 200,
                'success' => true,
                'flag' => 1,
                'event_id'=>$request->id,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => 200,
                'success'   => true,
                'flag' => 0,
                'message' => 'You have already booked the event with this time.',
            ];
            return response()->json($response, 200);
        }
    }
       
}
