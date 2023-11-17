<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\introductory;
use Image;
use App\Models\Event;
use App\Models\User;
use App\Models\eventduration;

class EventController extends Controller
{
    public function event(Request $request)
    {
    	  $event = Event::all();
    	  return view('admin.eventlist', compact('event'));
    }
     public function eventcreation(Request $request)
    {
      $eventduration = eventduration::get();
    	return view('admin.event_manage',compact('eventduration'));
    }
     public function eventstore(Request $request)
    {
      $sc_event = app('App\Http\Controllers\API\EventController')->eventcreate($request);
      $sc_eventArray = json_decode ($sc_event->content(), true);
      $va = $sc_eventArray['success'];
      if($va == 'true'){
        return response()->json($sc_eventArray['event_id']);
      }else{
        if(isset($sc_eventArray['flag']) == 1){
          return response()->json(['status' => 0,'message' => $sc_eventArray['message'], 'flag' => $sc_eventArray['flag']]);
        }else{
        return response()->json(['status' => 0, 'message' => $sc_eventArray['error']]);
        }
      }
    }

        public function editevent($id)
    {
      $id = base64_decode($id);
      $edit_event = app('App\Http\Controllers\API\EventController')->eventshowweb($id);
      $edit_eventArray = json_decode ($edit_event->content(), true);
      $edit_event = $edit_eventArray['data'];
      $eventduration = eventduration::get();
       
        return view('admin.event_edit', compact('edit_event','eventduration'));
    }
    public function updateevent(Request $request, $id)
    {
      $edit_event = app('App\Http\Controllers\API\EventController')->eventupdate($request,$id);
      $edit_eventArray = json_decode ($edit_event->content(), true);
      $va = $edit_eventArray['success'];
      if($va == 'true'){
        return response()->json($edit_eventArray['event_id']);
      }else{
        if($edit_eventArray['error']){
          return response()->json(['status' => 0, 'message' => $edit_eventArray['error']]);
        }else{
          return response()->json(['status' => 0, 'message' => $edit_eventArray['message']]);
        }
        
      }
    }
    public function deleteevent($id)
    {
        $id             = base64_decode($id);
        $deleteevent = Event::where([['id', $id]])->delete();
       
        if(!$deleteevent)
        {
            return redirect('/admin/event')->with('Error', 'Event not deleted');
        }
        return redirect('/admin/event')->with('Success', 'Event Deleted Successfully');

        }
}
