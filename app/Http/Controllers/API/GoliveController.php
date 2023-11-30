<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Livecount;
use App\Models\Eventbooking;
use App\Models\Event;
use App\Models\Artist_profiles;
use App\Models\Fansactivity;
use App\Models\fansactivitysummary;
use App\Models\fansactivitygraph;
use App\Models\subscriptionplan;
use App\Models\User;
use Response;
// use Illuminate\Support\Facades\Redis;
use DB;

class GoliveController extends Controller
{

    public function actioncount(Request $request){
        $eventid =$request->id;
            $e_id = Event::where('id',$eventid)->first();
            $inputs = [
                'fans_id' => auth()->user()->id,
                'event_id' => $eventid,
                'artist_id' =>$e_id->user_id,
                'activitytime'=> Carbon::now(),
                'actid1' =>$request->act1,
                'actid2' =>$request->act2,
                'actid3' =>$request->act3,
                'actid4' =>$request->act4,
                'actid5' =>$request->act5,
                'actid6' =>$request->act6,
                'activitystatus' => 1,
            ];
            $fan_activity = Fansactivity::where('fans_id',auth()->user()->id)->where('event_id',$eventid)->orderBy('id', 'desc')->take(1)->first();
            
            if($fan_activity){
                $inputs1 = [
                    'fans_id' => auth()->user()->id,
                    'event_id' => $eventid,
                    'artist_id' =>$e_id->user_id,
                    'activitytime'=> Carbon::now(),
                    'actid1' =>$request->act1,
                    'actid2' =>$request->act2,
                    'actid3' =>$request->act3,
                    'actid4' =>$request->act4,
                    'actid5' =>$request->act5,
                    'actid6' =>$request->act6,
                    'activitystatus' => 1,
                ];
                $fansactivity = Fansactivity::create($inputs1);
            }else{
                $fansactivity = Fansactivity::create($inputs);
            }
            // action count
            
                // action graph
                $inputsgraph = [
                    'fans_id' => auth()->user()->id,
                    'event_id' => $eventid,
                    'artist_id' =>$e_id->user_id,
                    'activitytime'=> Carbon::now(),
                    'actid1' =>$request->act1,
                    'actid2' =>$request->act2,
                    'actid3' =>$request->act3,
                    'actid4' =>$request->act4,
                    'actid5' =>$request->act5,
                    'actid6' =>$request->act6,
                    'activitystatus' => 1,
                ];
                 $fan_activitygraph = fansactivitygraph::where('fans_id',auth()->user()->id)->where('event_id',$eventid)->first();
                if($fan_activitygraph){
                    $fan_activitygraph->activitytime =Carbon::now();
                    // if($fan_activitygraph->actid1 + $request->act1 <=10){
                        $fan_activitygraph->actid1 = $fan_activitygraph->actid1 + $request->act1;
                    // }
                    // if($fan_activitygraph->actid2 + $request->act2 <=10){
                        $fan_activitygraph->actid2 =$fan_activitygraph->actid2 + $request->act2;
                    // }
                    // if($fan_activitygraph->actid3 + $request->act3 <=10){
                        $fan_activitygraph->actid3 =$fan_activitygraph->actid3 + $request->act3;
                    // }
                    // if($fan_activitygraph->actid4 + $request->act4 <=10){
                        $fan_activitygraph->actid4 =$fan_activitygraph->actid4 + $request->act4;
                    // }
                    // if($fan_activitygraph->actid5 + $request->act5 <=10){
                        $fan_activitygraph->actid5 =$fan_activitygraph->actid5 + $request->act5;
                    // }
                    // if($fan_activitygraph->actid6 + $request->act6 <=10){
                        $fan_activitygraph->actid6 =$fan_activitygraph->actid6 + $request->act6;
                    // }
                    
                    $fan_activitygraph->save();
                }else{
                    $fansactivitygraph = fansactivitygraph::create($inputsgraph);
                }
            return response()->json([
                'status'   => 200,
				'success' => true,
                'message' => 'Actions Saved Successfully',
			]);
    }
    public function livefanactioncount($id){
        $averages = Fansactivity::where('event_id',$id)->where('activitystatus',1)
                    ->select(DB::raw('avg(actid1) actid1, avg(actid2) actid2,avg(actid3) actid3, avg(actid4) actid4,avg(actid5) actid5, avg(actid6) actid6'))
                    ->get();

        // $keys = Redis::keys('FansActionCounts:'.$id);
        $user_count = [];
        foreach ($keys as $key) {
            // $stored = Redis::hgetall($key);
            // $user_count[] = $stored ;
        }
        $e_id = Event::where('id',$user_count[0]['eventid'])->first();
        
        $inputs = [
            'event_id' => $user_count[0]['eventid'],
            'artist_id' =>$e_id->user_id,
            'activitytime'=> Carbon::now(),
            'actid1' =>($averages[0]['actid1']) ? round($averages[0]['actid1']) : 0,
            'actid2' =>($averages[0]['actid2']) ? round($averages[0]['actid2']) : 0,
            'actid3' =>($averages[0]['actid3']) ? round($averages[0]['actid3']) : 0,
            'actid4' =>($averages[0]['actid4']) ? round($averages[0]['actid4']) : 0,
            'actid5' =>($averages[0]['actid5']) ? round($averages[0]['actid5']) : 0,
            'actid6' =>($averages[0]['actid6']) ? round($averages[0]['actid6']) : 0,
            'lastsumtime' => Carbon::now(),
            'activitystatus' => 1,
        ];
        $fanactivitysum = fansactivitysummary::where('event_id',$user_count[0]['eventid'])->first();
        if($fanactivitysum){
            $fanactivitysum->actid1 = ($averages[0]['actid1']) ? round($averages[0]['actid1']) : 0;
            $fanactivitysum->actid2 = ($averages[0]['actid2']) ? round($averages[0]['actid2']) : 0;
            $fanactivitysum->actid3 = ($averages[0]['actid3']) ? round($averages[0]['actid3']) : 0;
            $fanactivitysum->actid4 = ($averages[0]['actid4']) ? round($averages[0]['actid4']) : 0;
            $fanactivitysum->actid5 = ($averages[0]['actid5']) ? round($averages[0]['actid5']) : 0;
            $fanactivitysum->actid6 = ($averages[0]['actid6']) ? round($averages[0]['actid6']) : 0;
            $fanactivitysum->lastsumtime =Carbon::now();
            $fanactivitysum->save();
        }else{
            $fansactivitysummary = fansactivitysummary::create($inputs);
        }

        DB::table('fansactivities')
        ->where('event_id', $id)->where('activitystatus',1)
        ->update([
            'activitystatus' => 0,
            
        ]);
        return response()->json([
            'status'   => 200,
            'success' => true,
            'message' => 'Activitysummary Saved Successfully',
        ]);

    }
    public function fansactivitysummary($id){
        $fansactivitysummary = fansactivitysummary::where('event_id',$id)->first();
        return response()->json([
            'status'   => 200,
            'success' => true,
            'actid1' => $fansactivitysummary->actid1,
            'actid2' => $fansactivitysummary->actid2,
            'actid3' => $fansactivitysummary->actid3,
            'actid4' => $fansactivitysummary->actid4,
            'actid5' => $fansactivitysummary->actid5,
            'actid6' => $fansactivitysummary->actid6,
        ]);
    }
    public function golive($eventsid){
        $eventid =$eventsid;
            $data = [
                    'user_id' => auth()->user()->id,
                    'event_id' => $eventid,
                    'eventjoin_date' =>Carbon::now(),
                    'eventexit_date' => null,
                ];
                $live = Livecount::create($data);


        $eventid =$eventsid;
        $event = Event::where('id',$eventid)->first();
        if($event->eventamount > 0){
            $live = Eventbooking::where('event_id', $eventid)->where('user_id',auth()->user()->id)->first();
            $live->joinEvent_Time = Carbon::now();
            $live->exitEvent_Time = null;
            $live->save();
        }else{
            $eventStatus = Event::where(['id' => $eventid,'event_status' => 1])->first();
            $usertype = User::where('id', $eventStatus->user_id)
                ->where(function($query) {
                    $query->where('user_type', 'artists')
                          ->orWhere('user_type', 'users');
                })
                ->first();
            $planid = $usertype->subscription_plan_id;
            $f2splan = subscriptionplan::where('id',$planid)->first();
            $fans_per_event = $f2splan->fans_per_event;
            if($eventStatus){
                $user_count = Eventbooking::where('artist_id',$eventStatus->user_id)->where('event_id',$eventid)->where('status',1)->pluck('user_id')->toArray();
                if(count($user_count) < $fans_per_event){
                    $check_booking = Eventbooking::where('event_id', $eventid)->where('user_id',auth()->user()->id)->first();
                    if($check_booking){
                        $check_booking->joinEvent_Time = Carbon::now();
                        $check_booking->exitEvent_Time = null;
                        $check_booking->save();
                    }else{
                        $inputs = [ 
                            'artist_id' => $eventStatus->user_id,
                            'event_id' => $eventid,
                            'amount' => 0,
                            'payment_status' => 1,
                            'joinEvent_Time' => Carbon::now(),
                            'exitEvent_Time' => null,
                            'status' => 1,
                            'user_id' => auth()->user()->id
                        ];
                        Eventbooking::create($inputs);
                    }
                        
                    }
                }

        }
        $event = Event::with('userDetail')->find($eventid);
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
                
                $eventimage = explode(',',$event->event_image);
        
        // if($live){
            $data=[
                'event_id' => $event->id,
                'event_title' => $event->event_title,
                'event_date' => $event->event_date,
                'event_time' => $event->event_time,
                'link_to_event_stream' => $event->link_to_event_stream,
                'eventamount' => ($event->eventamount > 0)? $event->eventamount: 0,
                'booking_status' => ($eventStatus) ? true : false,
                'event_duration' => $event->event_duration,
                'event_image' => url('').'/eventimages/'.$eventimage[0],
                'event_genre' => $event->genre,
                'event_timezone' => $event->event_timezone,
                'event_description' => $event->event_description,
                'event_plan_type' => (int)$event->event_plan_type,
                'event_status' => $event->event_status,
                'artist_id' => $event->user_id,
                'artist_name' => $event->userDetail['name'],
                'artist_stagename' => $a_profile['stage_name'],
                'artist_image' =>(isset($a_profile['profile_image'])) ? url('').'/artist_profile_images/'.$a_profile['profile_image']: '',      
            ];
            return response()->json([
                'status'   => 200,
				'success' => true,
                'message' => 'Event retrieved successfully',
                'data' => $data
			]);
        // }
    }
    public function checklive($eventsid){
        $eventid =$eventsid;
        $eventStatus = Event::where(['id' => $eventid,'event_status' => 1])->first();
        if($eventStatus){
            return response()->json([
                'status'   => 200,
				'success' => true,
                'event_states'=> true,
                'message' => 'Event Live'
			]);
        }else{
            return response()->json([
                'status'   => 200,
				'success' => true,
                'event_states'=> false,
                'message' => 'Event End'
			]);
        }
            
    }
    public function livecount($id){
        

        $user_counts = Eventbooking::where('event_id',$id)->where('joinEvent_Time', '!=', NULL)->count();
        $checkendevent = Event::where('id',$id)->where('golivestatus',0)->where('event_status',0)->first();
        if($checkendevent){
            $checkendstatus = 1;
        }else{
            $checkendstatus = 0;
        }
        if($user_counts){
            $count = $user_counts;
            return response()->json([
                'status'   => 200,
				'success' => true,
                'message' => 'Live User Count Retrived successfully',
                'livecount' =>  $count,
                'checkendlive' => $checkendstatus
			]);
            
        }
    }
    public function actiongraphcount($id){
        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subSeconds(1);
        $useraction_counts = Fansactivity::where('event_id',$id)->where('fans_id',auth()->user()->id)->whereBetween('created_at',[$newDateTime,$currentDateTime])->get();
        // dd($user_counts);
        $act1 = 0;
        $act2 = 0;
        $act3 = 0;
        $act4 = 0;
        $act5 = 0;
        $act6 = 0;
        foreach($useraction_counts as $ac){
                $act1 += $ac->actid1;
                $act2 += $ac->actid2;
                $act3 += $ac->actid3;
                $act4 += $ac->actid4;
                $act5 += $ac->actid5;
                $act6 += $ac->actid6;
            }
            // $usergraph_counts = fansactivitygraph::where('event_id',$id)->where('fans_id',auth()->user()->id)->first();

            // $act11 = ((int)$usergraph_counts->actid1) - $act1;
            // $act12 = ((int)$usergraph_counts->actid2) - $act2;
            // $act13 = ((int)$usergraph_counts->actid3) - $act3;
            // $act14 = ((int)$usergraph_counts->actid4) - $act4;
            // $act15 = ((int)$usergraph_counts->actid5) - $act5;
            // $act16 = ((int)$usergraph_counts->actid6) - $act6;
            // $usergraph_counts->actid1 = $act11;
            // $usergraph_counts->actid2 = $act12;
            // $usergraph_counts->actid3 = $act13;
            // $usergraph_counts->actid4 = $act14;
            // $usergraph_counts->actid5 = $act15;
            // $usergraph_counts->actid6 = $act16;
            // $usergraph_counts->save();


            $user_counts = Eventbooking::where('event_id',$id)->where('joinEvent_Time', '!=', NULL)->count();
            $checkendevent = Event::where('id',$id)->where('golivestatus',0)->where('event_status',0)->first();
            if($checkendevent){
                $checkendstatus = 1;
            }else{
                $checkendstatus = 0;
            }

            if($useraction_counts){
                $count = $user_counts;
                return response()->json([
                    'status'   => 200,
                    'success' => true,
                    'message' => 'Graph count retrived successfully',
                    'act1' => $act1,
                    'act2' => $act2,
                    'act3' => $act3,
                    'act4' => $act4,
                    'act5' => $act5,
                    'act6' => $act6,
                    'livecount' =>  $count,
                'checkendlive' => $checkendstatus
                ]);
                
            }
        }
        public function artistactiongraphcount($id){
            $currentDateTime = Carbon::now();
            $newDateTime = Carbon::now()->subSeconds(5);
            // $useraction_counts = Fansactivity::where('event_id',$id)->where('artist_id',auth()->user()->id)->whereBetween('created_at',[$newDateTime,$currentDateTime])->get();
            // // dd($user_counts);
            // $act1 = 0;
            // $act2 = 0;
            // $act3 = 0;
            // $act4 = 0;
            // $act5 = 0;
            // $act6 = 0;
            // foreach($useraction_counts as $ac){
            //         $act1 += $ac->actid1;
            //         $act2 += $ac->actid2;
            //         $act3 += $ac->actid3;
            //         $act4 += $ac->actid4;
            //         $act5 += $ac->actid5;
            //         $act6 += $ac->actid6;
            //     }
            //     $usergraph_counts = fansactivitygraph::where('event_id',$id)->where('artist_id',auth()->user()->id)->get();
    
            // $actt1 = 0;
            // $actt2 = 0;
            // $actt3 = 0;
            // $actt4 = 0;
            // $actt5 = 0;
            // $actt6 = 0;
            // foreach($usergraph_counts as $act){
            //         $actt1 += $act->actid1;
            //         $actt2 += $act->actid2;
            //         $actt3 += $act->actid3;
            //         $actt4 += $act->actid4;
            //         $actt5 += $act->actid5;
            //         $actt6 += $act->actid6;
            //     }
            $useraction_counts = DB::select('SELECT 
            SUM(actid1) AS O1,
            SUM(actid2) AS O2,
            SUM(actid3) AS O3,
            SUM(actid4) AS O4,
            SUM(actid5) AS O5,
            SUM(actid6) AS O6,
            
            R1,
            R2,
            R3,
            R4,
            R5,
            R6,
            FA1.event_id 
        FROM 
            fansactivities FA1
        LEFT JOIN 
            (SELECT 
                
                SUM(actid1) AS R1,
                SUM(actid2) AS R2,
                SUM(actid3) AS R3,
                SUM(actid4) AS R4,
                SUM(actid5) AS R5,
                SUM(actid6) AS R6,
             FA2.event_id
            FROM 
                fansactivities FA2
            WHERE
                created_at > "'.$newDateTime.'" and created_at < "'.$currentDateTime.'") FA2 ON FA1.event_id = FA2.event_id
            WHERE FA1.event_id = "'.$id.'" and FA1.artist_id = "'.auth()->user()->id.'"
        GROUP BY 
            event_id ');
                if($useraction_counts){
                    return response()->json([
                        'status'   => 200,
                        'success' => true,
                        'message' => 'Graph count retrived successfully',
                        // 'act1' => $act1,
                        // 'act2' => $act2,
                        // 'act3' => $act3,
                        // 'act4' => $act4,
                        // 'act5' => $act5,
                        // 'act6' => $act6,
                        // 'actt1' => $actt1,
                        // 'actt2' => $actt2,
                        // 'actt3' => $actt3,
                        // 'actt4' => $actt4,
                        // 'actt5' => $actt5,
                        // 'actt6' => $actt6,
                        'act1' => (int)$useraction_counts[0]->R1,
                        'act2' => (int)$useraction_counts[0]->R2,
                        'act3' => (int)$useraction_counts[0]->R3,
                        'act4' => (int)$useraction_counts[0]->R4,
                        'act5' => (int)$useraction_counts[0]->R5,
                        'act6' => (int)$useraction_counts[0]->R6,
                        'actt1' => (int)$useraction_counts[0]->O1,
                        'actt2' => (int)$useraction_counts[0]->O2,
                        'actt3' => (int)$useraction_counts[0]->O3,
                        'actt4' => (int)$useraction_counts[0]->O4,
                        'actt5' => (int)$useraction_counts[0]->O5,
                        'actt6' => (int)$useraction_counts[0]->O6,
                    ]);
                    
                }
            }
    public function totalactioncount($id){
        
       
        $usergraph_counts = fansactivitygraph::where('event_id',$id)->where('fans_id',auth()->user()->id)->first();

            $act1 = (int)$usergraph_counts->actid1;
            $act2 = (int)$usergraph_counts->actid2;
            $act3 = (int)$usergraph_counts->actid3;
            $act4 = (int)$usergraph_counts->actid4;
            $act5 = (int)$usergraph_counts->actid5;
            $act6 = (int)$usergraph_counts->actid6;

            if($usergraph_counts){
                return response()->json([
                    'status'   => 200,
                    'success' => true,
                    'message' => 'total action count retrived successfully',
                    'act1' => $act1,
                    'act2' => $act2,
                    'act3' => $act3,
                    'act4' => $act4,
                    'act5' => $act5,
                    'act6' => $act6,
                ]);
                
            }
        }
    
    public function liveshow($id)
    {
        // --------------------------------
        $keys = Redis::keys('usercount:*');
        $clients = [];
        foreach ($keys as $key) {
        $stored = Redis::hgetall($key);
        $clients[] = $stored ;
        }
        dd($clients);
        // ----------------------------------------

        // $redis = Redis::connection();
        // $response = $redis->get('fanscounts');

        // $response = json_decode($response);
        // $count = $redis->get('fanscounts:*');

        // dd($response);

//         $popular     =   Redis::keys('fanscounts:*');
//         dd($popular);
//         $get_count   = [];
//         foreach ($popular as $key => $res) {
//             // Get news_id
//             $news_id    =   explode( ":", $res );

//             // Get count each post
//             $get_count[$news_id[3] ]  =   Redis::get( $res );
// }
// $sort = arsort( $get_count );

// dd($sort);






        // $visits = Redis::incr('visits'); 
        // dd($visits);

        // $redis    = Redis::connection();
        // $response = $redis->get('user_details');

        // $response = json_decode($response);
        
       
        // try{
        //     // Redis::get('user:profile:'.$id);
        //     return view('user.profile', [
        //             'user' => Redis::get('user:profile:'.$id)
        //         ]);

        // }catch(Exception $e){
        //     dd($e->message());

        // }
        // $redis = Redis::connection();
        // $redis->set('name', 'Vimal');
 
        // $values = $redis->lrange('names', 5, 10);
        // dd($values);
        // dd(Redis::get('user:profile:'.$id));
        // return view('user.profile', [
        //     'user' => Redis::get('user:profile:'.$id)
        // ]);
    }

    public function exitliveevent(Request $request,$id){
        $event_id =base64_decode($id);

        if($event_id){
            $keys = Redis::keys('FansCounts:'.$event_id);
            $user_count = [];
            foreach ($keys as $key) {
            $stored = Redis::hgetall($key);
            $user_count[] = $stored ;
            }
            $countvalue = $user_count[0]['eventcount'] - 1;

            Redis::hmset('FansCounts:'.$event_id,[
                'eventid' => $event_id,
                'eventcount' => $countvalue,
                'updatedat' => Carbon::now(),
                ]);
            $live = Eventbooking::where('event_id', $event_id)->where('user_id',auth()->user()->id)->first();
            $live->exitEvent_Time = Carbon::now();
            $live->save();
        }
        return redirect()->route('live-event', base64_encode($event_id));
    }
    public function livefancount($id){

    }
}
