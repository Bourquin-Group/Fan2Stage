<?php

namespace App\Http\Controllers\API;

use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Eventbooking;
use Illuminate\Http\Request;
use App\Models\Artist_profiles;
use App\Models\subscriptionplan;
use App\Models\billinginformation;
use App\Http\Controllers\Controller;
use App\Models\Event_joined_by_fans;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;
use Session;
use App\Models\timezone;
use App\Models\Notificationdetail;
use App\Http\Controllers\API\BaseController as BaseController;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function eventall()
    {
        $events = Event::all();
        $data = [];
            foreach($events as $i => $value){
                $data['events'][$i]['id'] = $value->id;
                $data['events'][$i]['title'] = $value->event_title;
                $data['events'][$i]['date'] = $value->event_date;
                $data['events'][$i]['time'] = $value->event_time;
                $data['events'][$i]['link_to_event_stream'] = $value->link_to_event_stream;
                $data['events'][$i]['duration'] = $value->event_duration;
                $data['events'][$i]['image'] = url('').'/eventimages/'.$value->event_image;
                $data['events'][$i]['genre'] = $value->genre;
                $data['events'][$i]['description'] = $value->event_description;
                $data['events'][$i]['status'] = $value->event_status;
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
            }else{
                $response = [
                    'status' => 404,
                    'success' => false,
                    'message' => 'No Event Found',
                ];
                return response()->json($response, 404);
            }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function eventcreate(Request $request)
    {
        $timezone_region = timezone::where('id',Auth::user()->timezone)->first();
        if($timezone_region){
        date_default_timezone_set($timezone_region['region']);
        }
        $authid = Auth::User()->id;
        $usertype = User::where('id',$authid)->first();
        $planid = $usertype->subscription_plan_id;
        $f2splan = subscriptionplan::where('id',$planid)->first();
        $events_per_month = $f2splan->events_per_month;
        $events_cost = $f2splan->cost;
        $data = Event::select('*')
                    ->whereMonth('created_at', Carbon::now()->month)->where('user_id',$authid)
                    ->get();

        $Events_per_month_count = count($data);
        if($usertype->user_type=='artists' || $usertype->user_type=='admin' || $usertype->typeupgrade_status == 1)
        {
            if($Events_per_month_count<$events_per_month)
            {
                // $checktime = date("H:i:s", strtotime($request['event_time']));
                // // dd($checktime);
                // $eventcheck = Event::where('user_id',$authid)->where('event_date',$request ['event_date'])->where('event_time',$checktime)->first();
                // if($eventcheck){
                //     $response = [
                //         'success'   => false,
                //         'flag' => 1,
                //         'message' => 'Already event will be existing with this time and date',
                //     ];
                //     return response()->json($response);
                // }else{

                    $eventsToday = Event::where('user_id', $authid)
                    ->where('event_status',1)
                    ->whereDate('event_date', $request['event_date']) // Filter events for today's date
                    ->get(); // Retrieve all events for today

                $falltime = strtotime($request['event_time']);

                foreach ($eventsToday as $event) {
                    $event_starttime = strtotime($event->event_time);
                    $event_closetime = strtotime($event->event_closetime);

                    if ($falltime >= $event_starttime && $falltime <= $event_closetime) {
                        $response = [
                            'success' => false,
                            'flag' => 1,
                            'message' => 'An event already exists with this time and date.',
                        ];
                        return response()->json($response);
                    }
                }
                // $input = $request->all();
                // dd($request ['event_date']);
                $todayDate = date('Y-m-d');
                $validator = Validator::make($request->all(), [
                    'event_title' => 'required',
                    'event_duration' => 'required',
                    'link_to_event_stream' => 'required',
                    // 'eventamount' => 'numeric',
                    'genre' => 'required',
                    'number' => 'required|numeric|min:1',
                    'event_date' => 'required|after_or_equal:'.$todayDate,
                    'event_time' => 'required',
                    'event_timezone' => 'required',
                    'event_description' => 'required',
                    // 'eventamount' => 'numeric'
                ],
                [
                    'event_title.required' => 'Please Enter The Event Title',
                    'event_duration.required' => 'Please Select Event Duration',
                    'number.min' => 'Please Upload The Event Image',
                    'event_time.required' => 'Please Select The Event Time',
                    'genre.required' => 'Please Select  The Genre ',
                    'link_to_event_stream.required' => 'Please Give The Event Link',
                    // 'eventamount.required' => 'Please Enter The Amount',
                    // 'eventamount.numeric' => 'Please Give Only Digits',
                    'event_date.required' => 'Please Select The Event Date',
                    'event_date.after_or_equal' => 'Please Select Today or Next Date',
                    'event_timezone.required' => 'Please Select The Time Zone',
                    'event_description.required' => 'Please Enter The Event Discription',
                    
                ]);
            

                
                if($validator->fails()){
                    return response()->json(['success' => false, 'error' => $validator->errors()->toArray()]);
                }
                
                    $number  = $request['number'];
                    if($number){
                        $fil = [];
                    for($i =0; $i<$number; $i++)
                    {
                    $name = $request['file_name'.$i];
                    $tmp = $request['file'.$i];
                    $destinationPath = public_path().'/eventimages/'.$name;
                    move_uploaded_file($tmp,$destinationPath);
                    $fil[]=$name;
                    }
                    $filename_array = implode(',',$fil);
                }

                // $files = $request->file('event_image');
                // if($files){
                //     $fil = [];
                //     foreach($files as $file){
                //                 $fileName = $file->getClientOriginalName();
                //                 $destinationPath = public_path().'/eventimages' ;
                //                 $file->move($destinationPath,$fileName);
                //                 $fil[]=$fileName;
                //     }
                //     $filename_array = implode(',',$fil);
                // }else{
                //     $filename_array = $data->event_image;
                // }
                
                // url twitch and youtube
                $myString = $request['link_to_event_stream'];
                
                $contains = Str::contains($myString, 'player.twitch.tv');
                if($contains){
                    $contains1 = str_replace("www.example.com", "onstage.f2s.live", $myString);
                }else{
                    $contains1 = $request['link_to_event_stream'];
                }
                
                
                 $contains2 = Str::contains($myString, 'www.twitch.tv');
                if($contains2){
                    $url = $request['link_to_event_stream'];
                // Parse the URL
                $urlParts = parse_url($url);

                if (isset($urlParts['path'])) {
                    // Remove leading slash if present
                    $path = ltrim($urlParts['path'], '/');
                    
                    // Split the path by '/' and get the username (which is the last part)
                    $pathParts = explode('/', $path);
                    $username = end($pathParts);
                    if($username == '' || $username == NULL){
                        $response = [
                            'success'   => false,
                            'flag' => 1,
                            'message' => 'Invalid Url',
                        ];
                        return response()->json($response);
                    }else{
                        $contains1 = "https://player.twitch.tv/?channel=".$username."&parent=onstage.f2s.live";
                    }
                    
                    
                }else{
                    $contains1 = $request['link_to_event_stream'];
                } 
                }else {
                    $contains1 = $request['link_to_event_stream'];
                }

                // youtube
                $contains3 = Str::contains($myString, 'watch?v=');
                if($contains3){
                    $badUrl = $request['link_to_event_stream'];
                    $contains1 = str_replace('watch?v=', 'embed/', $badUrl);
                }
                $contains5 = Str::contains($myString, 'youtu.be');
                if($contains5){
                    $badUrl = $request['link_to_event_stream'];
                    $contains1 = str_replace('youtu.be', 'www.youtube.com/embed', $badUrl);
                }
                // dd($contains1);
//                 $contains4 = Str::contains($myString, '?si=');
//                 // https://youtu.be/EQ783EHQkng?si=jTV8piWnHfWTQMRL
//                 if($contains4){
//                     $url = $request['link_to_event_stream'];
//                 // Parse the URL
//                 $urlParts = parse_url($url);
//                 if (isset($urlParts['path'])) {
//                     // Remove leading slash if present
//                     $path = ltrim($urlParts['path'], '/');
                    
//                     // Split the path by '/' and get the username (which is the last part)
//                     $pathParts = explode('/', $path);
//                     $youtubename = end($pathParts);
//                     $contains1 = "https://www.youtube.com/embed/".$youtubename;
//                 }
//                 }


                // youtube
                // url twitch and youtube
                $duration = $request['event_duration'] * 60;
                $newTime = strtotime($request['event_time']) + $duration;
                $inputs = [ 
                    'event_title' => $request['event_title'],
                    'event_duration' => $request['event_duration'],
                    'event_image' => $filename_array,
                    'event_status' => 1,
                    'link_to_event_stream' => $contains1,
                    'eventamount' => ($request['eventamount'] != null)? $request['eventamount'] : 0 ,
                    'genre' => $request['genre'],
                    'event_count' => 0,
                    'event_description' => $request['event_description'],
                    'event_date' => $request ['event_date'],
                    'event_plan_type' => ($events_cost == 'free') ? 0 : 1,
                    'event_time' => date("H:i:s", strtotime($request['event_time'])),
                    'event_closetime' => date("H:i:s", $newTime),
                    'event_timezone' => $request ['event_timezone'],
                    'user_id' => auth()->user()->id
                ];
                    $Event = Event::create($inputs);
                    // mail notification
                    
                    $data = array(
                        'name' => Auth::user()->name,
                        'eventname' => $Event->event_title,
                        'eventdate' => date('d F Y', strtotime($Event->event_date)),
                        'eventtime' => date("H:i A", strtotime($Event->event_time)),
                    );
                    $email = Auth::user()->email;
                    

                    $favouriteuserid = Favourite::where('artist_id',Auth::user()->id)->pluck('user_id')->toArray();
                    $favouriteuseremail = User::whereIn('id',$favouriteuserid)->pluck('email')->toArray();
                    $favouriteuser = User::whereIn('id',$favouriteuserid)->get();
                   
                    foreach($favouriteuser as $value){
                        // dd($value);
                        $notification_detail = [
                            'type_name' => 'Event Create',
                            'description' => Auth::user()->name.' created a Event',
                            'event_id' => $Event->id,
                            'artist_id' => Auth::user()->id,
                            'status' => 1,
                            'type' => 1,
                            'user_id' =>$value->id 
                    ];
                        Notificationdetail::create($notification_detail);
                    }

                    // Push notification
                    $FcmToken = User::whereIn('id',$favouriteuserid)->whereNotNull('device_token')->pluck('device_token')->all();
                    
                    $title = "Event Create";
                    $body = Auth::user()->name.' created a Event';
                    $event_id = $Event->id;
                    $status = ($Event->golivestatus == 1) ? true : false;
                    $type = "CREATED";
                    send_notification_FCM($FcmToken,$title, $body, $event_id, $status, $type);
                    // Push notification
 
                    

                      Mail::send('mail.eventcreate',$data,function($message) use($email,$favouriteuseremail){
                        $message->to($email);
                        $message->cc($favouriteuseremail);
                        $message->subject('Congratulations');
                        });
                        // mail notification

                    $response = [
                        'status_code'   => 200,
                        'success'   => true,
                        'event_name'   => $Event->event_title,
                        'event_id'   => $Event->event_id,
                        'message' => 'Event created successfully',
                    ];
                    return response()->json($response, 200);
                // }
                }
                else{
                    $response = [
                        'success'   => false,
                        'flag' => 1,
                        'message' => 'You Have Reached Events Per Month',
                    ];
                    return response()->json($response);
                }
        }
        else{
             $response = [
                
                'success'   => false,
                'message' => 'You Could Not Create The Event',
            ];
            return response()->json($response);
        }
    }
    public function eventshow($id)
    {
            $event = Event::with('userDetail')->find($id);
            // $event = Event::with('userDetail')->where('user_id',Auth::user()->id)->find($id);
                if (is_null($event)) {
                    return response()->json([
                        'status'   => 404,
                        'success' => false,
                        'message' => 'No Event Found',
                    ]);
                }
                $a_profile = Artist_profiles::where('user_id',$event->userDetail['id'])->first();
                
                // check event book by fan
                $eventStatus = Eventbooking::where(['event_id' => $event->id,'artist_id' => $event->user_id,'status' => 1,'user_id' => auth()->user()->id])->first();
                // check event book by fan

                // check billing information
                $billdetail = billinginformation::where('user_id',auth()->user()->id)->first();
                // check billing information
                $followers = Favourite::where('artist_id',optional($a_profile->userArtist)->id ? optional($a_profile->userArtist)->id : '')->pluck('id')->toArray();

                $review =Event_joined_by_fans::where('user_id',$event->userDetail['id'])->get();
                $raiting = 0;
                if($review->isNotEmpty())
                {
                    $raiting = ceil($review->sum('ratings')/$review->count());
                }
                
                $eventimage = explode(',',$event->event_image);
            $data=[
                'user_id' => auth()->user()->id,
                'event_id' => $event->id,
                'event_title' => $event->event_title,
                'event_date' => $event->event_date,
                'event_time' => $event->event_time,
                'link_to_event_stream' => $event->link_to_event_stream,
                'eventamount' => ($event->eventamount > 0)? (int)$event->eventamount: 0,
                'booking_status' => ($eventStatus) ? true : false,
                'billinginfo_status' => ($billdetail) ? true : false,
                'verified_profile' => (Auth::user()->verified_profile == 1) ? true : false,
                'event_duration' => $event->event_duration,
                'event_image' => url('').'/eventimages/'.$eventimage[0],
                'event_genre' => $event->genre,
                'event_timezone' => $event->event_timezone,
                'event_description' => $event->event_description,
                'event_plan_type' => (int)$event->event_plan_type,
                'event_status' => (int)$event->event_status,
                'artist_id' => $event->user_id,
                'artist_name' => $event->userDetail['name'],
                'artist_stagename' => (isset($a_profile['stage_name'])) ? $a_profile['stage_name'] : '',
                'd_stagename' => (isset($a_profile['d_stagename'])) ? $a_profile['d_stagename'] : 'off',
                'artist_image' =>(isset($a_profile['profile_image'])) ? url('').'/artist_profile_images/'.$a_profile['profile_image']: '',      
                'is_completed' => ($event->event_status == 0) ? 0 : 1,
                'followers'=> count($followers),
                'raiting'=> $raiting,
            ];
            return response()->json([
                'status'   => 200,
				'success' => true,
                'message' => 'Event retrieved successfully',
                'data' => $data
			]);
    }
    public function eventshowweb($id)
    {
            $event = Event::with('userDetail')->find($id);
            // $event = Event::with('userDetail')->where('user_id',Auth::user()->id)->find($id);
                if (is_null($event)) {
                    return response()->json([
                        'status'   => 404,
                        'success' => false,
                        'message' => 'No Event Found',
                    ]);
                }
                $a_profile = Artist_profiles::where('user_id',$event->userDetail['id'])->first();

                // check event book by fan
                $eventStatus = Eventbooking::where(['event_id' => $event->id,'artist_id' => $event->user_id,'status' => 1,'user_id' => auth()->user()->id])->first();
                // check event book by fan

                // check billing information
                $billdetail = billinginformation::where('user_id',auth()->user()->id)->first();
                // check billing information

            $data=[
                'event_id' => $event->id,
                'event_title' => $event->event_title,
                'event_date' => $event->event_date,
                'event_time' => $event->event_time,
                'link_to_event_stream' => $event->link_to_event_stream,
                // 'eventamount' => $event->eventamount,
                'eventamount' => ($event->eventamount > 0)? $event->eventamount: 0,
                'booking_status' => ($eventStatus) ? true : false,
                'billinginfo_status' => ($billdetail) ? true : false,
                'event_duration' => $event->event_duration,
                'event_image' => $event->event_image,
                'event_genre' => $event->genre,
                'event_timezone' => $event->event_timezone,
                'event_description' => $event->event_description,
                'event_status' => $event->event_status,
                'artist_id' => $event->user_id,
                'eventstart' => $event->starteventflag,
                'artist_name' => $event->userDetail['name'],
                'artist_image' => (isset($a_profile['profile_image'])) ? url('').'/artist_profile_images/'.$a_profile['profile_image']: '',
            ];
            return response()->json([
                'status'   => 200,
				'success' => true,
                'message' => 'Event retrieved successfully',
                'data' => $data
			]);
    }

    public function eventupdate(Request $request, $id)
    {
        $timezone_region = timezone::where('id',Auth::user()->timezone)->first();
        if($timezone_region){
        date_default_timezone_set($timezone_region['region']);
        }
        // dd($request);
        $authid = Auth::User()->id;
        $usertype = User::where('id',$authid)->first();
        if($usertype->user_type=='artists' || $usertype->user_type=='admin' || $usertype->typeupgrade_status == 1)
        {
                $input = $request->all();
                $todayDate = date('Y-m-d');
                $event = Event::where('id',$request->id)->first();
                $validation = [
                        'event_title' => 'required',
                        'event_duration' => 'required',
                        'link_to_event_stream' => 'required',
                        // 'eventamount' => 'numeric',
                        'genre' => 'required',
                        // 'number' => 'required|numeric|min:1',
                        'event_date' => 'required|after_or_equal:'.$todayDate,
                        'event_time' => 'required',
                        'event_timezone' => 'required',
                        'event_description' => 'required',
                        // 'eventamount' => 'numeric'
                    ];
                    if(!$event->event_image || $event->event_image == null){
                        $event_image = [ 'number' => 'required|numeric|min:1',];
                        $validation = array_merge($validation, $event_image);
                    }
                    
                    $validator = Validator::make($request->all(),$validation,
                    [
                        'event_title.required' => 'Please Enter The Event Title',
                    'event_duration.required' => 'Please Select Event Duration',
                    'number.min' => 'Please Upload The Event Image',
                    'event_time.required' => 'Please Select The Event Time',
                    'genre.required' => 'Please Select  The Genre ',
                    'link_to_event_stream.required' => 'Please Give The Event Link',
                    // 'eventamount.required' => 'Please Enter The Amount',
                    // 'eventamount.numeric' => 'Please Give Only Digits',
                    'event_date.required' => 'Please Select The Event Date',
                    'event_date.after_or_equal' => 'Please Select Today or Next Date',
                    'event_timezone.required' => 'Please Select The Time Zone',
                    'event_description.required' => 'Please Enter The Event Discription',
                    ]
                );
            

                
                if($validator->fails()){
                    return response()->json(['success' => false, 'error' => $validator->errors()->toArray()]);
                }
                $number  = $request['number'];
                if($number == 0){
                    $filename_array = $request['oldimg'];
                }else{
                    // dd('2',$number);
                    if($number > 0){
                        $fil = [];
                    for($i =0; $i<$number; $i++)
                    {
                    $name = $request['file_name'.$i];
                    // dd($name);
                    $tmp = $request['file'.$i];
                    $destinationPath = public_path().'/eventimages/'.$name;
                    move_uploaded_file($tmp,$destinationPath);
                    $fil[]=$name;
                    }
                        $oldimg_array = explode(',',$request['oldimg']);
                        $old_new = array_merge(array_filter($oldimg_array),$fil);
                        $filename_array = implode(',',$old_new);
                    
                }else{
                    if(Auth::user()->user_type == 'admin'){
                        $event = Event::where('id',$id)->first();
                    }else{
                        $event = Event::where('user_id',Auth::user()->id)->where('id',$id)->first();
                    }

                    $filename_array = $event->event_image;
                }
                }
                    
                    
                    if(Auth::user()->user_type == 'admin'){

                        $event = Event::where('id',$id)->first();
                    }else{

                        $event = Event::where('user_id',Auth::user()->id)->where('id',$id)->first();
                    }
                if($event){
                    // url twitch and youtube
                
                $myString = $input['link_to_event_stream'];
                
                $contains = Str::contains($myString, 'player.twitch.tv');
                if($contains){
                    $contains1 = str_replace("www.example.com", "onstage.f2s.live", $myString);
                }else{
                    $contains1 = $request['link_to_event_stream'];
                }
                
                
                 $contains2 = Str::contains($myString, 'www.twitch.tv');
                if($contains2){
                    $url = $input['link_to_event_stream'];
                // Parse the URL
                $urlParts = parse_url($url);

                if (isset($urlParts['path'])) {
                    // Remove leading slash if present
                    $path = ltrim($urlParts['path'], '/');
                    
                    // Split the path by '/' and get the username (which is the last part)
                    $pathParts = explode('/', $path);
                    $username = end($pathParts);
                    
                    if($username == '' || $username == NULL){
                        $response = [
                            'success'   => false,
                            'flag' => 1,
                            'message' => 'Invalid Url',
                        ];
                        return response()->json($response);
                    }else{
                        $contains1 = "https://player.twitch.tv/?channel=".$username."&parent=onstage.f2s.live";
                    }
                    
                }else{
                    $contains1 = $request['link_to_event_stream'];
                } 
                }else {
                    $contains1 = $request['link_to_event_stream'];
                }
                // youtube
                $contains3 = Str::contains($myString, 'watch?v=');
                if($contains3){
                    $badUrl = $request['link_to_event_stream'];
                    $contains1 = str_replace('watch?v=', 'embed/', $badUrl);
                }

                $contains4 = Str::contains($myString, '?si=');
                // https://youtu.be/EQ783EHQkng?si=jTV8piWnHfWTQMRL
                if($contains4){
                    $url = $request['link_to_event_stream'];
                // Parse the URL
                $urlParts = parse_url($url);
                if (isset($urlParts['path'])) {
                    // Remove leading slash if present
                    $path = ltrim($urlParts['path'], '/');
                    
                    // Split the path by '/' and get the username (which is the last part)
                    $pathParts = explode('/', $path);
                    $youtubename = end($pathParts);
                    $contains1 = "https://www.youtube.com/embed/".$youtubename;
                }
                }
                // youtube
                // url twitch and youtube

                    // dd(date("g:i:s", strtotime($input['event_time']." GMT")));
                    $event->event_title = $input['event_title'];
                    $event->event_duration = $input['event_duration'];
                    $event->event_image =  $filename_array;
                    $event->link_to_event_stream = $contains1;
                    $event->eventamount = $input['eventamount'];
                    $event->genre = $input['genre'];
                    $event->event_timezone = $input['event_timezone'];
                    $event->event_date = $input['event_date'];
                    $event->event_time =date("H:i:s", strtotime($input['event_time']));
                    $duration = $input['event_duration'] * 60;
                    $newTime = strtotime($input['event_time']) + $duration;
                    $event->event_closetime =date("H:i:s", $newTime);
                    $event->event_description = $input['event_description'];
                    $event->event_status = 1;
                    $event->save();
                    $data = array(
                        'name' => Auth::user()->name,
                        'eventname' => $event->event_title,
                        'eventdate' => date('d F Y', strtotime($event->event_date)),
                        'eventtime' => date("H:i A", strtotime($event->event_time)),
                    );
                    $email = Auth::user()->email;

                    $bookeduserid = Eventbooking::where('event_id',$id)->where('status',1)->pluck('user_id')->toArray();
                    $bookeduseremail = User::whereIn('id',$bookeduserid)->pluck('email')->toArray();

                    $bookeduser = User::whereIn('id',$bookeduserid)->get();
                   
                    foreach($bookeduser as $value){
                        $notification_detail = [
                            'type_name' => 'Event Update',
                            'description' => Auth::user()->name.' modify a Event',
                            'event_id' => $event->id,
                            'artist_id' => Auth::user()->id,
                            'status' => 1,
                            'type' => 5, //5->Event update
                            'user_id' =>$value->id 
                    ];
                        Notificationdetail::create($notification_detail);
                    }

                    // Push notification
                    $FcmToken = User::whereIn('id',$bookeduserid)->whereNotNull('device_token')->pluck('device_token')->all();
                    
                    $title = "Event Update";
                    $body = Auth::user()->name.' modify a Event';
                    $event_id = $event->id;
                    $status = ($event->golivestatus == 1) ? true : false;
                    $type = "MODIFY";
                    send_notification_FCM($FcmToken,$title, $body, $event_id, $status, $type);
                    // Push notification

                    // dd($bookeduseremail);

                      Mail::send('mail.eventupdate',$data,function($message) use($email,$bookeduseremail){
                        $message->to($email);
                        $message->cc($bookeduseremail);
                        $message->subject('Congratulations');
                        });
                    return response()->json([
                        'status'   => 200,
                        'success' => true,
                        'message' => 'Event updated successfully',
                        'event_id'   => $event->id,
                        // 'data' => $event
                    ]);
                    
                }
                // }
                else{
                    $response = [
                        'status'  => 404,
                        'success' => false,
                        'message' => 'Event not updated',
                    ];
                    return response()->json($response, 404);
                }
        }
        else{
            $response = [
                    'success'   => false,
                    'message' => 'You Could Not Update The Event',
                    ];
                    return response()->json($response);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eventdestroy($id)
    {
        $authid = Auth::User()->id;
        $usertype = User::where('id',$authid)->first();
        $bookeduserid = Eventbooking::where('event_id',$id)->where('status',1)->pluck('user_id')->toArray();
        $bookeduser = User::whereIn('id',$bookeduserid)->get();
                   
                    foreach($bookeduser as $value){
                        $notification_detail = [
                            'type_name' => 'Event Delete',
                            'description' => Auth::user()->name.' delete a Event',
                            'event_id' => $id,
                            'artist_id' => Auth::user()->id,
                            'status' => 1,
                            'type' => 6, //5->Event delete
                            'user_id' =>$value->id 
                    ];
                        Notificationdetail::create($notification_detail);
                    }
                    // Push notification
                    $FcmToken = User::whereIn('id',$bookeduserid)->whereNotNull('device_token')->pluck('device_token')->all();
                    
                    $title = "Event Delete";
                    $body = Auth::user()->name.' delete a Event';
                    $event_id = $id;
                    $status = false;
                    $type = "DELETED";
                    send_notification_FCM($FcmToken,$title, $body, $event_id, $status, $type);
                    // Push notification
        //dd($usertype->user_type);
        if($usertype->user_type=='artists')
        {
            $event = Event::where('user_id',Auth::user()->id)->where('id',$id)->first();
            if($event){

                $event->delete();
                return response()->json([
                    'status'  => 200,
                    'success' => true,
                    'message' => 'Event Deleted Successfully',
                    'data' => []
                ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Event Not Deleted Successfully', // the ,message you want to show
                    
                ], 422);
            }
        }
        else{
            $response = [
                    'status'   => false,
                    'message' => 'You Could Not Delete The Event',
                ];
            return response()->json($response);
        }
}

    public function liveEventList(){
        // $allLiveEvents = Event::where('event_status',1)->where('event_date', Carbon::today())->get();
        // $allLiveEvents = Event::where('event_status',1)->where('golivestatus', 1)->where('event_date', Carbon::today())->get();
        $yesterday = Carbon::yesterday()->toDateString();
// $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();

        $allLiveEvents = Event::where('event_status', 1)
            ->where('golivestatus', 1)
            ->whereBetween('event_date', [$yesterday, $tomorrow])
            ->orderBy('event_time')
            ->get();
        $data = [];
        $totData = [];
        foreach($allLiveEvents as $value){

            $date = DateTime::createFromFormat('H:i:s',$value->event_time);
            $date->modify('+'.$value->event_duration.' minutes');
            $event_web_start_time = date("g:i A", strtotime($value->event_time." UTC"));
            $event_web_end_time = $date->format('h:i A');

            $data['event_id']=$value->id;
            $data['event_title']=$value->event_title;
            $data['event_date']=$value->event_date;
            $eventStatus = Eventbooking::where(['event_id' => $value->id,'artist_id' => $value->user_id,'status' => 1,'user_id' => auth()->user()->id])->first();
            $data['booking_status']=($eventStatus) ? true : false;
            $data['event_duration']=$value->event_duration;
            $data['event_amount']=($value->eventamount > 0)? (int)$value->eventamount: 0;
            $data['event_time']=$value->event_time;
            $timezone_region = timezone::where('timezone',$value->event_timezone)->first();
            $data['event_timezone']=$timezone_region->region;
            $data['event_web_start_time']=$event_web_start_time;
            $data['event_web_end_time']=$event_web_end_time;
            $data['event_plan_type']=(int)$value->event_plan_type;
            $eventimage = explode(',',$value->event_image);
            $data['event_image']=asset('/eventimages/'.$eventimage[0]);
            $totData[]=$data;
        }
        $response = [
            'status'  => 200,
            'success' => true,
            'message' => "Live Event Data Retrived Successfully",
            'data'    => $totData,
        ];
        return response()->json($response, 200);
    }
    public function liveEventListApi(){
        $timezone_region = timezone::where('id',Auth::user()->timezone)->first();
        if($timezone_region){
        date_default_timezone_set($timezone_region['region']);
        }
        // $allLiveEvents = Event::where('event_status',1)->where('event_date', Carbon::today())->get();
        // $allLiveEvents = Event::where('event_status',1)->where('golivestatus', 1)->where('event_date', Carbon::today())->get();
        $yesterday = Carbon::yesterday()->toDateString();
        // $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();

        $allLiveEvents = Event::where('event_status', 1)
            ->where('golivestatus', 1)
            ->whereBetween('event_date', [$yesterday, $tomorrow])
            ->orderBy('event_time')
            ->get();
        $data = [];
        $totData = [];
        foreach($allLiveEvents as $value){
            $timezone_region = timezone::where('id',Auth::user()->timezone)->first();
            $eventdate = date('Y-m-d',strtotime($value->event_date));
            $eventtime = $value->event_time ;
            $eventdatetime = $eventdate.' '.$eventtime;       
            
            $date = new DateTime($eventdatetime, new DateTimeZone($value->event_timezone));

            $date->setTimezone(new DateTimeZone($timezone_region->region));
            $resultdatefrom = $date->format('h:i A');

            $minutesToAdd = $value->event_duration; // Change this to your desired duration

            // Add the minutes to the DateTime object
            $date->modify("+{$minutesToAdd} minutes");

            // Format the modified DateTime to the desired output
            $resultdateto = $date->format('h:i A');
            $event_web_start_time = $resultdatefrom;
            $event_web_end_time = $resultdateto;

            $data['event_id']=$value->id;
            $data['event_title']=$value->event_title;
            $data['event_date']=$value->event_date;
            $eventStatus = Eventbooking::where(['event_id' => $value->id,'artist_id' => $value->user_id,'status' => 1,'user_id' => auth()->user()->id])->first();
            $data['booking_status']=($eventStatus) ? true : false;
            $data['event_duration']=$value->event_duration;
            $data['event_amount']=($value->eventamount > 0)? (int)$value->eventamount: 0;
            
            $data['event_time']=$resultdatefrom;
            $data['event_web_start_time']=$event_web_start_time;
            $data['event_web_end_time']=$event_web_end_time;
            $data['event_plan_type']=(int)$value->event_plan_type;
            $eventimage = explode(',',$value->event_image);
            $data['event_image']=asset('/eventimages/'.$eventimage[0]);
            $totData[]=$data;
        }
        $response = [
            'status'  => 200,
            'success' => true,
            'message' => "Live Event Data Retrived Successfully",
            'data'    => $totData,
        ];
        return response()->json($response, 200);
    }
    public function scheduledEventList(){
        $scheduleEvents = Event::where('event_status',1)->where('event_date','>=',Carbon::today())->where('golivestatus', 0)->orderBy('event_time')->get();
        $data = [];
        $totData = [];
        foreach($scheduleEvents as $value){
            $data['event_id']=$value->id;
            $data['event_title']=$value->event_title;
            $data['event_date']=$value->event_date;
            $eventStatus = Eventbooking::where(['event_id' => $value->id,'artist_id' => $value->user_id,'status' => 1,'user_id' => auth()->user()->id])->first();
            $data['booking_status']=($eventStatus) ? true : false;
            $data['event_duration']=$value->event_duration;
            $data['event_amount']=($value->eventamount > 0)? (int)$value->eventamount: 0;
            $data['event_time']=$value->event_time;
            $data['event_description']=$value->event_description;
            $data['event_plan_type']=(int)$value->event_plan_type;
            $timezone_region = timezone::where('timezone',$value->event_timezone)->first();
            $data['event_timezone']=$timezone_region->region;

            $eventimage = explode(',',$value->event_image);
            $data['event_image']=asset('/eventimages/'.$eventimage[0]);
            

            $totData[]=$data;
        }
        $response = [
            'status' => 200,
            'success' => true,
            'message' => "Scheduled Event Data Retrived Successfully",
            'data'    => $totData,
        ];
        // dd($totData);
        return response()->json($response, 200);    
    }
    public function scheduledEventListApi(){
        $timezone_region = timezone::where('id',Auth::user()->timezone)->first();
        if($timezone_region){
        date_default_timezone_set($timezone_region['region']);
        }
        $scheduleEvents = Event::where('event_status',1)->where('event_date','>=',Carbon::today())->where('golivestatus', 0)->orderBy('event_time')->get();
        $data = [];
        $totData = [];
        foreach($scheduleEvents as $value){
            $data['event_id']=$value->id;
            $data['event_title']=$value->event_title;
            $data['event_date']=$value->event_date;
            $eventStatus = Eventbooking::where(['event_id' => $value->id,'artist_id' => $value->user_id,'status' => 1,'user_id' => auth()->user()->id])->first();
            $data['booking_status']=($eventStatus) ? true : false;
            $data['event_duration']=$value->event_duration;
            $data['event_amount']=($value->eventamount > 0)? (int)$value->eventamount: 0;
            $timezone_region = timezone::where('id',Auth::user()->timezone)->first();
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
            // dd($dateTime);
            $data['event_time']=$resultdatefrom ;
            $data['event_description']=$value->event_description;
            $data['event_plan_type']=(int)$value->event_plan_type;
            $eventimage = explode(',',$value->event_image);
            $data['event_image']=asset('/eventimages/'.$eventimage[0]);
            

            $totData[]=$data;
        }
        $response = [
            'status' => 200,
            'success' => true,
            'message' => "Scheduled Event Data Retrived Successfully",
            'data'    => $totData,
        ];
        // dd($totData);
        return response()->json($response, 200);    
    }
    public function viewEventDetails(Request $request){
        $getEventDetails = Event::with('userDetail')->where('id',$request->id)->first();
        $data = [];
        $data['event_title']=$getEventDetails->event_title;
        $data['artisan_name']=$getEventDetails->userDetail[0]->name;
        $data['event_description']=$getEventDetails->event_description;
        $response = [
            'status' => 200,
            'success' => true,
            'data'    => $data,
            'message' => 'Event Details Retrived Succefully',
        ];
        return response()->json($response, 200);    
    }


     public function startevent(Request $request){
        
        $id = Auth()->user()->id;
        //dd($id);
        $event_details  = Event::where('user_id',$id)->where('id',$request->event_id)->get();
       $event_id = $request->event_id;
        //dd($event_details);
        $usertype = User::where('id',$id)->first();
        if($usertype->user_type=='artists')
        {
         if(($event_details[0]['start_at'] =='') && ($event_details[0]['id']==$event_id)){
        $startevent = [
            //'id' => $request->event_id,
            'start_at' => date("Y-m-d h:i:s"),
        ];
            $planUpdate  = Event::where('user_id',$id)->where('id',$request->event_id)->update($startevent);

         $response = [
            'status_code'   => 200,
            'status'   => true,
            'message' => 'Event Started successfully',
        ];
        return response()->json($response, 200); 
    }
    else{
         $response = [
                
                'status'   => false,
                'message' => 'Your Event Already Started',
            ];
        return response()->json($response);
    }
        }
        else{
        $response = [
                
                'status'   => false,
                'message' => 'You Could Not Start The Event',
            ];
        return response()->json($response);
        }    
        
    }


       public function endevent(Request $request){
        
        $id = Auth()->user()->id;
         $event_details  = Event::where('user_id',$id)->where('id',$request->event_id)->get();
          $usertype = User::where('id',$id)->first();
        if($usertype->user_type=='artists')
        {
             if(($event_details[0]['start_at'] !='') && ($event_details[0]['id']==$request->event_id)){
        $endevent = [
            'end_at' =>date("Y-m-d h:i:s"),
            ];
            $planUpdate  = Event::where('user_id',$id)->update($endevent);
        
         $response = [
            'status_code'   => 200,
            'status'   => true,
            'message' => 'Event Ended Successfully',
        ];
        return response()->json($response, 200);
    }
    else{
    $response = [
                
                'status'   => false,
                'message' => 'Your Event Not Started',
            ];
        return response()->json($response);
    }
         }
        else{
        $response = [
                
                'status'   => false,
                'message' => 'You Could Not Able to Close The Event',
            ];
        return response()->json($response);
        }         
        
    }

    
}
