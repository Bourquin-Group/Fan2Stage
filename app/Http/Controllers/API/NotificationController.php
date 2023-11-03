<?php

namespace App\Http\Controllers\API;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\FavouriteNotificationResource;
use App\Http\Resources\EventBookingCancelNotificationResource;
use App\Models\Artist_profiles;
use App\Models\Notificationdetail;
use App\Models\User;
use Carbon\Carbon;
use DB;

class NotificationController extends Controller
{
    
    public function listFavouriteEvent(){
        $user = Auth::user();
        $notificationList = Notification::where('type',1)->where('status',0)->get();
        $data = FavouriteNotificationResource::collection($notificationList);
        $response = [
            'success'   => true,
            'data'   => $data,
        ];
        return response()->json($response, 200); 
    }

    public function eventBookingCancel()
    {
        $user = Auth::user();
        $notificationList = Notification::where('type',4)->where('status',0)->get();
        $data = EventBookingCancelNotificationResource::collection($notificationList);
        $response = [
            'success'   => true,
            'data'   => $data,
        ];
        return response()->json($response, 200); 
    }
    public function notification_history(Request $request)
    {
        $notify = Notificationdetail::where('user_id',Auth::user()->id)->where('read',0)->orderBy('created_at', 'desc')->get();
        // dd($notify);

        $data = [];
            foreach($notify as $i => $value){
                $data['notify'][$i]['id'] = $value->id;
                $data['notify'][$i]['artist_id'] = $value->artist_id;
                $data['notify'][$i]['description'] = $value->description;
                $data['notify'][$i]['read'] = $value->read;
                $data['notify'][$i]['status'] = $value->status;
                $data['notify'][$i]['event_id'] = $value->event_id;
                $timestamp = $value->created_at;

                // Create a Carbon instance from the timestamp
                $carbonTimestamp = Carbon::parse($timestamp);

                // Get the human-readable relative time
                $relativeTime = $carbonTimestamp->diffForHumans();
                $data['notify'][$i]['date'] = $relativeTime;
                $artistDetail = Artist_profiles::whereHas('userArtist')->where('user_id',$value->artist_id)->first();
                $data['notify'][$i]['profile_image']=url('').'/artist_profile_images/'.$artistDetail['profile_image'];
            }
            if($data){
                $response = [
                    'status' => 200,
                    'success' => true,
                    'message' => 'Notification Retrived Successfully',
                    'data'    => $data,
                ];
                return response()->json($response, 200);
            }else{
                $response = [
                    'status' => 404,
                    'success' => false,
                    'message' => 'Notifications not Found',
                    'data'    => $data,
                ];
                return response()->json($response, 404);
            }
    }
    public function notifyread($id)
    {
        $notify = Notificationdetail::where('id',$id)->where('read',0)->first();

        if($notify){
            $notify->read = 1;
            $notify->save();

            $notify = Notificationdetail::where('user_id',Auth::user()->id)->where('read',0)->orderBy('created_at', 'desc')->get();
        // dd($notify);

        $data = [];
            foreach($notify as $i => $value){
                $data['notify'][$i]['id'] = $value->id;
                $data['notify'][$i]['artist_id'] = $value->artist_id;
                $data['notify'][$i]['description'] = $value->description;
                $data['notify'][$i]['read'] = $value->read;
                $data['notify'][$i]['status'] = $value->status;
                $data['notify'][$i]['event_id'] = $value->event_id;
                $timestamp = $value->created_at;

                // Create a Carbon instance from the timestamp
                $carbonTimestamp = Carbon::parse($timestamp);

                // Get the human-readable relative time
                $relativeTime = $carbonTimestamp->diffForHumans();
                $data['notify'][$i]['date'] = $relativeTime;
                $artistDetail = Artist_profiles::whereHas('userArtist')->where('user_id',$value->artist_id)->first();
                $data['notify'][$i]['profile_image']=url('').'/artist_profile_images/'.$artistDetail['profile_image'];
            }
            if($data){
                $response = [
                    'status' => 200,
                    'success' => true,
                    'message' => 'Notification Retrived Successfully',
                    'data'    => $data,
                ];
                return response()->json($response, 200);
            }else{
                $response = [
                    'status' => 200,
                    'success' => true,
                    'message' => 'Notifications not Found',
                    'data'    => $data,
                ];
                return response()->json($response, 200);
            }

        }else{
            $response = [
                'status' => 200,
                'success' => true,
                'message' => 'Notifications not Found',
                'data'    => $data,
            ];
            return response()->json($response, 200);
        }
    }
    public function notifyreadall()
    {
        $updatedRows = DB::table('notificationdetails')
                        ->where('user_id', Auth::user()->id)
                        ->where('read', 0)
                        ->update(['read' => 1]);

        $notify = Notificationdetail::where('user_id',Auth::user()->id)->where('read',0)->orderBy('created_at', 'desc')->get();
        // dd($notify);

        $data = [];
                $response = [
                    'status' => 200,
                    'success' => true,
                    'message' => 'Notification cleared Successfully',
                    'data'    => $data,
                ];
                return response()->json($response, 200);

       
    }

    public function updateDeviceToken(Request $request)
    {
        Auth::user()->device_token =  $request->token;

        
        Auth::user()->save();
        $response = [
            'status' => 200,
            'success' => true,
            'message' => 'Token successfully stored.',
        ];
        return response()->json($response, 200);
    }

}
