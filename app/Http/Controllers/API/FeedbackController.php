<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Event_joined_by_fans;
use Illuminate\Support\Facades\Auth;
use App\Models\Eventbooking;
use App\Models\Event;
use Carbon\Carbon;
class FeedbackController extends Controller
{
    public function event_Joined_by_fans(Request $request){
        // $input = $request->all();
        // $validator = Validator::make($input, [
        //     'artist_id' => 'required',
        //     'event_id' => 'required',
        //     'event_review' => 'required',
        //     'rating' => 'required',
        // ]);
   
        // if($validator->fails()){
        //     return response()->json([
        //         'message' => 'Invalid params passed',
        //           'errors' => $validator->errors()
        //       ], 422);       
        // }
        
        // $inputs = [ 
        //     'artist_id' => $request->artist_id,
        //     'event_id' => $request->event_id,
        //     'event_review' => $request->event_review,
        //     'ratings' => $request->rating,
        //     'user_id' => auth()->user()->id
        // ];
        //     $Event = Event_joined_by_fans::create($inputs);
        //     if($Event){
        //     $response = [
        //         'success'   => true,
        //         'message' => 'Thanks for your Feedback',
        //     ];
        //     return response()->json($response, 200);
        // }else{
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'No more Feedback',
        //     ]);
        // }
        $input = $request->all();
        if($request->rating < 3 || $request->rating == NULL){
            $validator =Validator::make($request->all(),[
                'rating' => 'required|min:3',
            'event_review'=>'required',
        ],
        [
            'rating.required'=> 'Please give your ratings',
            'rating.min'=> 'Please provide above 2 ratings',
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
                            $artistid = Event::where(['id' => $eventid,'event_status' => 0])->first();
                            $inputs = [ 
                                'artist_id' => $artistid->user_id,
                                'event_id' => $eventid,
                                'event_review' => $request->event_review,
                                'ratings' => $request->rating,
                                'user_id' => $authid
                            ];
                                $Event = Event_joined_by_fans::create($inputs);
            if($Event && $booking_id){
                    $booking_id->event_status = 0;
                    $booking_id->eventreviewstatus = 0;
                    $booking_id->exitEvent_Time = Carbon::now();
                    $booking_id->save();
                    return response()->json([
                        'status'   => 200,
                        'success' => true,
                        'event_id' =>$eventid,
                        'message' => 'Successfully Exit From The Event',
                    ]);
                }
    }
}
