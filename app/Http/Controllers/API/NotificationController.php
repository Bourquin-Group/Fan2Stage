<?php

namespace App\Http\Controllers\API;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\FavouriteNotificationResource;
use App\Http\Resources\EventBookingCancelNotificationResource;


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

}
