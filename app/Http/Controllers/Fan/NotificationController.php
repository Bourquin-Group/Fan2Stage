<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notify(Request $request){
        $liveevent = app('App\Http\Controllers\API\NotificationController')->notification_history($request);
        $liveeventArray = json_decode ($liveevent->content(), true);
        $liveevent_data = $liveeventArray['data'];
        return response()->json($liveevent_data);
    }
    public function notifyread($id){
        $read = app('App\Http\Controllers\API\NotificationController')->notifyread($id);
        $readArray = json_decode ($read->content(), true);
        $read_data = $readArray['data'];
        return response()->json($read_data);
    }
    public function notifyreadall(Request $request){
        $read = app('App\Http\Controllers\API\NotificationController')->notifyreadall($request);
        $readArray = json_decode ($read->content(), true);
        $read_data = $readArray['data'];
        return response()->json($read_data);
    }
}
