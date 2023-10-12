<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Event;
use App\Models\Event_joined_by_fans;
use App\Models\Artist_profiles;
use App\Models\Eventbooking;
use App\Models\Favourite;
use App\Models\timezone;
use App\Models\timezone_change;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Session;

class ArtistController extends Controller
{
    public function createArtist(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'stagename' => 'required',
            'mobile_number' => ['required','numeric','digits:10'],
            'genre' => 'required',
            'timezone' => 'required',
            'profile_image' => 'required',
            'landpage_image' => 'required',
            'bio' => 'required',
        ]);
        

        if($validator->fails()){
            return response()->json([
                'message' => 'Invalid params passed', // the ,message you want to show
                  'errors' => $validator->errors()
              ], 422);       
        }

        $user = User::where('id',$request->user_id)->first();
        if($user){
        // ===============================================
        // artist profile images
        $file = $request->file('profile_image') ;
        $fileName = $file->getClientOriginalName() ;
        $destinationPath = public_path().'/artist_profile_images' ;
        $file->move($destinationPath,$fileName);
        // artist profile images
        
        // artist landing page images
        $file1 = $request->file('landpage_image') ;
        $fileName1 = $file1->getClientOriginalName() ;
        $destinationPath1 = public_path().'/artist_landingpage_images' ;
        $file1->move($destinationPath1,$fileName1);
        // artist landing page images
        $inputs = [ 
            'user_id' => $user->id,
            'stage_name' => $request->stagename,
            'genre' => $request->genre,
            'timezone' => $request->timezone,
            'website_link' => $request->website_link,
            'itunes_link' => $request->itunes_link,
            'youtube_link' => $request->youtube_link,
            'instagram_link' => $request->instagram_link,
            'facebook_link' => $request->facebook_link,
            'bio' => $request->bio,
            'profile_image' => $fileName,
            'landing_page_image' => $fileName1
        ];
                $Artist = Artist_profiles::create($inputs);
        // ===============================================
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
        ]);
    }

    }
    public function updateArtist(Request $request){
        $input = $request->all();
        $authid = Auth::user()->id;
        $artist = Artist_profiles::where('user_id',$authid)->first();
        $validation = [
            'full_name' => ['required','string','regex:/^[a-z|A-Z]+(?: [a-z|A-Z]+)*$/'],
            'email' => ['required','regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'],
            'stagename' => 'required',
            'mobile_number' => ['required'],
            // 'mobile_number' => ['required','numeric','digits:10'],
            'genre' => 'required',
            'timezone' => 'required',
            'bio' => 'required',
            
        ];
        if($request->facebook_link != null){
            $facebbok_validation = [ 'facebook_link' => 'url'];
            $validation = array_merge($validation, $facebbok_validation);
        }
        if($request->instagram_link != null){
            $instagram_link_validation = [ 'instagram_link' => 'url'];
            $validation = array_merge($validation, $instagram_link_validation);
        }
        if($request->itunes_link != null){
            $itunes_link_validation = [ 'itunes_link' => 'url'];
            $validation = array_merge($validation, $itunes_link_validation);
        }
        if($request->youtube_link != null){
            $youtube_link_validation = [ 'youtube_link' => 'url'];
            $validation = array_merge($validation, $youtube_link_validation);
        }
        if($request->website_link != null){
            $website_link_validation = [ 'website_link' => 'url'];
            $validation = array_merge($validation, $website_link_validation);
        }

        if(!$artist->profile_image || $artist->profile_image == null){
            // dd($input['landing_page_image']);
            $profileimage_validation = [ 'profile_image' => 'required|mimes:jpeg,png,jpg,gif,svg'];
            $validation = array_merge($validation, $profileimage_validation);
        }
        if(!$artist->landing_page_image || $artist->landing_page_image == null){
            $landingimage_validation = [ 'landing_page_image' => 'required'];
            $validation = array_merge($validation, $landingimage_validation);
        }     
        $validator = $this->validate($request,$validation,
        [
            'full_name.required' => 'Please enter the name',
            'full_name.string' => 'Please type only string',
            'full_name.regex' => 'Please enter characters only',
            'email.required' => 'Please enter the email',
            'email.regex'=> 'Invalid email address',
            'mobile_number.required' => 'Please enter the mobile number',
            'genre.required' => 'Please select  the genre ',
            'timezone.required' => 'Please select  the timezone ',
            'profile_image.required' => 'Please upload the profile pic',
            'profile_image.mimes' => 'Please upload only profile jpeg,png,jpg,svg,gif',
            'landing_page_image.required' => 'Please upload the landingpage image',
            'landing_page_image.mimes' => 'Please upload only landing jpeg,png,jpg,svg,gif',
            'bio.required' => 'Please enter the bio-Data',
            
        ]
    );
        if($artist){
            // artist profile images
            $file = $request->file('profile_image');
            
            if($file){
                $fileName = $file->getClientOriginalName();
                $destinationPath = public_path().'/artist_profile_images' ;
                $file->move($destinationPath,$fileName);
                $old_path =public_path('/artist_profile_images/'.$artist->profile_image);
                if(File::exists($old_path) && $artist->profile_image) {
                    unlink($old_path);
                }
            }else{
                $fileName = $artist->profile_image;
            }
            // artist profile images
            
            // artist landing page images
            // $file1 = $request->file('landing_page_image');
            $image_parts = explode(";base64,", $input['landing_page_image']);
            
            // if($image_parts){
                // $fileName1 = $file1->getClientOriginalName() ;
                // $destinationPath1 = public_path().'/artist_landingpage_images' ;
                // $file1->move($destinationPath1,$fileName1);
                    $folderPath = public_path('/artist_landingpage_images/');
                    
                    $image_type_aux = explode("image/", $image_parts[0]);
                    if(isset($image_type_aux[1])){
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName1 = time() . '.'. $image_type;
                    $file =$folderPath.$fileName1;
                    file_put_contents($file, $image_base64);
                $old_path =public_path('/artist_landingpage_images/'.$artist->landing_page_image);
                if(File::exists($old_path) && $artist->landing_page_image) {
                    unlink($old_path);
                }
            }else{
                $fileName1 = $artist->landing_page_image;
            }
            // artist landing page images
            
            // $artist->phone_number = $input['mobile_number'];
            $artist->stage_name = $input['stagename'];
            $artist->genre = implode(',',$input['genre']);
            $artist->d_stagename = (isset($input['dsname'])) ? $input['dsname'] : '' ;
            $artist->website_link = (isset($input['website_link'])) ? $input['website_link'] : '';
            $artist->itunes_link = (isset($input['itunes_link'])) ? $input['itunes_link'] : '';
            $artist->youtube_link = (isset($input['youtube_link'])) ? $input['youtube_link'] : '';
            $artist->instagram_link = (isset($input['instagram_link'])) ? $input['instagram_link'] : '';
            $artist->facebook_link = (isset($input['facebook_link'])) ? $input['facebook_link'] : '';
            $artist->bio = $input['bio'];
            $artist->profile_image = $fileName;
            $artist->landing_page_image = $fileName1;
            $artist->save();

            $user = User::where('email',$request->email)->where('id',$authid)->first();
            if($user){
                $user->name = $input['full_name'];
                $user->phone_number = $input['mobile_number'];
                $user->email = $input['email'];
                $user->timezone = $input['timezone'];
                $user->verified_profile = 1;
                $user->save();
                Session::put('user_timezone', $input['timezone']);
                // update day light time change
                if($request['timezone'] != null){
                    $timezone_date = timezone_change::where('user_id',Auth::user()->id)->first();
                    $effectiveDate = date('Y-m-d');
                    if($timezone_date){
                        $timezone_date->modify_date = date('Y-m-d', strtotime("+3 months", strtotime($effectiveDate)));
                        $timezone_date->status = 1;
                        $timezone_date->save();
                        Session::put('timezonechange', "yes");
                    }else{
                        $inputsss = [
                            'status' => 1,
                            'modify_date' => date('Y-m-d', strtotime("+3 months", strtotime($effectiveDate))),
                            'user_id' => auth()->user()->id
                        ];
                        timezone_change::create($inputsss);
                        Session::put('timezonechange', "yes");
                    }
                    
                }
                // update day light time change
            }
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Profile not updated successfully',
            ]);
        }
       
    }
    public function timezone_no(Request $request){
        $timezone_date = timezone_change::where('user_id',Auth::user()->id)->first();
        $effectiveDate = date('Y-m-d');
        if($timezone_date){
            $timezone_date->modify_date = date('Y-m-d', strtotime("+1 months", strtotime($effectiveDate)));
            $timezone_date->status = 0;
            $timezone_date->save();
            Session::put('timezonechange', true);
            return response()->json([
                'status'    =>200,
                'success' => true,
                'message' => 'timezone change successfully',
            ]);

        }else{
            $inputsss = [
                'status' => 0,
                'modify_date' => date('Y-m-d', strtotime("+1 months", strtotime($effectiveDate))),
                'user_id' => auth()->user()->id
            ];
            timezone_change::create($inputsss);
            Session::put('timezonechange', true);
            return response()->json([
                'status'    =>200,
                'success' => true,
                'message' => 'timezone change successfully',
            ]);
        }
}
    public function allArtist(Request $request){
        $artistDetail = Artist_profiles::with('userArtist')->get();

        foreach($artistDetail as $value){
            $data['artist_name'] = (isset($value->userArtist->name)) ? $value->userArtist->name : '';
            $data['id'] = $value->user_id;
            $data['stagename'] = $value->stage_name;
            $data['genre'] = $value->genre;
            $data['website_link'] = $value->website_link ;
            $data['itunes_link'] = $value->itunes_link ;
            $data['youtube_link'] = $value->youtube_link; 
            $data['instagram_link'] = $value->instagram_link;
            $data['facebook_link'] = $value->facebook_link;
            $data['profile_image'] = $value->profile_image;
            $data['bio'] = $value->bio;
            // $ratings1 = Event_joined_by_fans::where('artist_id',$value->id)->first();
            // $data['ratings'] = $ratings1->ratings;
            
            $artist[]=$data;
        }
   
        if($artist){
            $response = [
                'success'        => true,
                'message'           => 'Artist Data Retrived Successfully',
                'data'          => $artist,
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                'success'        => false,
                'message'           => 'No Data Found'
                
            ];
            return response()->json($response, 204);
        }
            
    }

    public function artistDetail(Request $request){
        // $artist_id = $request->artist_id;
        $authid = Auth::user()->id; 
        $artistDetail = Artist_profiles::whereHas('userArtist')->where('user_id',$authid)->first();
        $aProfile = [];
        if($artistDetail){
            $aProfile['stage_name']=$artistDetail['stage_name'];
            $aProfile['genre']=$artistDetail['genre'];
            $aProfile['d_stagename']=$artistDetail['d_stagename'];
            $aProfile['website_link']=$artistDetail['website_link'];
            $aProfile['youtube_link']=$artistDetail['youtube_link'];
            $aProfile['itunes_link']=$artistDetail['itunes_link'];
            $aProfile['instagram_link']=$artistDetail['instagram_link'];
            $aProfile['facebook_link']=$artistDetail['facebook_link'];
            $aProfile['bio']=$artistDetail['bio'];
            $aProfile['profile_image']=url('').'/artist_profile_images/'.$artistDetail['profile_image'];
            $aProfile['landing_page_image']=url('').'/artist_landingpage_images/'.$artistDetail['landing_page_image'];
            $aProfile['name']=$artistDetail['userArtist']['name'];
            $aProfile['email']=$artistDetail['userArtist']['email'];
            $aProfile['phone']=$artistDetail['userArtist']['phone_number'];
            // $aProfile['timezone']=($artistDetail['userArtist']['timezone'] != NULL)? $artistDetail['userArtist']['timezone'] : '-';
            $timezone = timezone::where('id',Session::get('user_timezone'))->first();
            $aProfile['timezone']=($artistDetail['userArtist']['timezone'] != NULL)? $timezone : '-';
            $followers = Favourite::where('artist_id',$artistDetail['userArtist']['id'])->pluck('id')->toArray();
            $aProfile['followers']=count($followers);
            $review =Event_joined_by_fans::where('user_id',$artistDetail['userArtist']['id'])->get();
                $raiting = 0;
                if($review->isNotEmpty())
                {
                    $raiting = ceil($review->sum('ratings')/$review->count());
                }
            $aProfile['raiting']=$raiting;
        }
        // $artistName = $artistDetail->name;
        $artistEventDetails = Event::where('user_id',$authid)->where('deleted_at',Null)->get();
        $pastEvent = [];$topastEvent = [];
        $sceduleEvent = [];$toSceduleEvent = [];
        foreach ($artistEventDetails as $value) {
            if($value->event_status == 0 && $value->event_date <= Carbon::today()){
                $pastEvent['id'] = $value->id;
                $pastEvent['event_title'] = $value->event_title;
                $pastEvent['event_time'] = $value->event_time;
                $pastEvent['date'] = $value->event_date;
                $pastEvent['time'] = $value->event_time;
                $pastEvent['link_to_event_stream'] = $value->link_to_event_stream;
                $pastEvent['duration'] = $value->event_duration;
                $pastEvent['image'] = $value->event_image;
                $pastEvent['genre'] = $value->genre;
                $pastEvent['description'] = $value->event_description;
                $pastEvent['count'] = $value->event_count;
                $topastEvent[]=$pastEvent; 
            }
            if($value->event_status == 1 && $value->event_date >= Carbon::today()){
                $sceduleEvent['id'] = $value->id;
                $sceduleEvent['event_title'] = $value->event_title;
                $sceduleEvent['event_time'] = $value->event_time;
                $sceduleEvent['date'] = $value->event_date;
                // $sceduleEvent['event_time'] = $eventDateTime;
                $sceduleEvent['link_to_event_stream'] = $value->link_to_event_stream;
                $sceduleEvent['duration'] = $value->event_duration;
                $sceduleEvent['image'] = $value->event_image;
                $sceduleEvent['genre'] = $value->genre;
                $sceduleEvent['description'] = $value->event_description;
                $sceduleEvent['count'] = $value->event_count;
                $toSceduleEvent[]=$sceduleEvent;        
            }   
        }

        // get current live event of artist
        $artistliveEvent = Event::where('user_id',$authid)->where('event_date',Carbon::today())->where('starteventflag',0)->where('event_status',1)->orderBy('event_time','ASC')->get();
        $live_event = [];
        $tolive_event = [];
        // dd($artistliveEvent);
        foreach ($artistliveEvent as $value) {
            
            $even = date('H:i A', strtotime($value->event_time));
            
            // $current_time = date('H:i A');
            $event_time_set= timezone::where('id',Auth::user()->timezone)->first();
            $dateNow = Carbon::now();
            $dateNow->setTimezone($event_time_set->region);
            $current_time = date('H:i A',strtotime($dateNow));
            
            if($current_time < $even){
                // dd($value->id,$even,$current_time);
                $live_event['id'] = $value->id;
                $live_event['event_title'] = $value->event_title;
                $live_event['event_time'] = $value->event_time;
                $live_event['date'] = $value->event_date;
                $eventDateTime = Carbon::parse($value->event_time)->tz(Auth::user()->timezone);
                // dd(Auth::user()->timezone);
                $live_event['time'] = $eventDateTime;
                $live_event['link_to_event_stream'] = $value->link_to_event_stream;
                $live_event['duration'] = $value->event_duration;
                $live_event['image'] = $value->event_image;
                $live_event['genre'] = $value->genre;
                $live_event['description'] = $value->event_description;
                $live_event['count'] = $value->event_count;
                $tolive_event[]=$live_event;
            }
        }
        // dd($tolive_event);
        // get current live event of artist
        $response = [
            'success'        => true,
            'profile'           => $aProfile,
            'past_event'     => $topastEvent,
            'sceduled_event' => $toSceduleEvent,
            'live_event' => $tolive_event,
        ];
        return response()->json($response, 200);    
    }
    public function apiArtistDetail($id){
        $user = Auth::user();
        $artistDetail = Artist_profiles::with('userArtist')->where('user_id',$id)->get();
        $aProfile = [];
        foreach($artistDetail as $artistprofile){
            $favourite = Favourite::where('user_id',$user->id)->where('artist_id',$artistprofile->user_id)->first();
            $aProfile['stage_name']=$artistprofile->stage_name;
            $aProfile['genre']=$artistprofile->genre;
            $aProfile['website_link']=$artistprofile->website_link;
            $aProfile['youtube_link']=$artistprofile->youtube_link;
            $aProfile['itunes_link']=$artistprofile->itunes_link;
            $aProfile['instagram_link']=$artistprofile->instagram_link;
            $aProfile['facebook_link']=$artistprofile->facebook_link;
            $aProfile['bio']=$artistprofile->bio;
            $aProfile['d_stagename']=(isset($artistprofile->d_stagename)) ? $artistprofile->d_stagename : 'off';
            $aProfile['profile_image']=url('').'/artist_profile_images/'.$artistprofile->profile_image;
            $aProfile['landing_page_image']=$artistprofile->landingPage();
            $aProfile['name']= optional($artistprofile->userArtist)->name ? optional($artistprofile->userArtist)->name : '';
            $aProfile['email']=optional($artistprofile->userArtist)->email ? optional($artistprofile->userArtist)->email : '';
            $aProfile['phone']=optional($artistprofile->userArtist)->phone_number ? optional($artistprofile->userArtist)->phone_number : '';
            $followers = Favourite::where('artist_id',optional($artistprofile->userArtist)->id ? optional($artistprofile->userArtist)->id : '')->pluck('id')->toArray();
            $aProfile['followers']=count($followers);
            $aProfile['favourite_status']=$favourite?1:0;
            $aProfile['artist_id']=$artistprofile->user_id;
            $review =Event_joined_by_fans::where('user_id',$artistprofile->user_id)->get();
                $raiting = 0;
                if($review->isNotEmpty())
                {
                    $raiting = ceil($review->sum('ratings')/$review->count());
                }
                $aProfile['raiting']=$raiting;
            
        }
        // $artistName = $artistDetail->name;
        $artistEventDetails = Event::where('user_id',$id)->where('deleted_at',Null)->get();
        $liveEvent = [];$toliveEvent = [];
        $sceduleEvent = [];$toSceduleEvent = [];
        foreach ($artistEventDetails as $value) {
            if($value->event_status == 1 && $value->event_date == Carbon::today() && $value->golivestatus == 1){
                $liveEvent['event_id'] = $value->id;
                $liveEvent['event_title'] = $value->event_title;
                $liveEvent['date'] = $value->event_date;
                $liveEvent['time'] = $value->event_time;
                $liveEvent['link_to_event_stream'] = $value->link_to_event_stream;
                $liveEvent['duration'] = $value->event_duration;
                $eventStatus = Eventbooking::where(['event_id' => $value->id,'artist_id' => $value->user_id,'status' => 1,'user_id' => auth()->user()->id])->first();
                $liveEvent['booking_status']=($eventStatus) ? true : false;
                $liveEvent['event_amount']=($value->eventamount > 0)? $value->eventamount: 0;
                $eventimage = explode(',',$value->event_image);
                $liveEvent['image'] = url('').'/eventimages/'.$eventimage[0];
                $liveEvent['genre'] = $value->genre;
                $liveEvent['description'] = $value->event_description;
                $liveEvent['count'] = $value->event_count;
                $toliveEvent[]=$liveEvent; 
            }
            if($value->event_status == 1 && $value->event_date >= Carbon::today() && $value->golivestatus == 0){
                $sceduleEvent['event_id'] = $value->id;
                $sceduleEvent['event_title'] = $value->event_title;
                $sceduleEvent['date'] = $value->event_date;
                $sceduleEvent['time'] = $value->event_time;
                $sceduleEvent['link_to_event_stream'] = $value->link_to_event_stream;
                $sceduleEvent['duration'] = $value->event_duration;
                $eventStatus = Eventbooking::where(['event_id' => $value->id,'artist_id' => $value->user_id,'status' => 1,'user_id' => auth()->user()->id])->first();
                $sceduleEvent['booking_status']=($eventStatus) ? true : false;
                $sceduleEvent['event_amount']=($value->eventamount > 0)? $value->eventamount: 0;
                $eventimage = explode(',',$value->event_image);
                $sceduleEvent['image'] = url('').'/eventimages/'.$eventimage[0];
                $sceduleEvent['genre'] = $value->genre;
                $sceduleEvent['description'] = $value->event_description;
                $sceduleEvent['count'] = $value->event_count;
                $toSceduleEvent[]=$sceduleEvent;   
            }   
        }
        $response = [
            'success'        => true,
            'profile'           => $aProfile,
            'live_event'     => $toliveEvent,
            'sceduled_event' => $toSceduleEvent,
        ];
        return response()->json($response, 200);    
    }
    public function eventhistory(Request $request){
        $allLiveEvents = Event::where('event_status',0)->where('user_id',auth()->user()->id)->get();
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
            $data['event_amount']=($value->eventamount > 0)? $value->eventamount: 0;
            $data['event_time']=$value->event_time;
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
}
