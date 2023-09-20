<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
//use App\Http\Requests\SubscriptionPlanRequest;
use App\Models\subscriptionplan;

class SubscriptionPlanController extends Controller
{
     public function subscriptionplanlist(Request $request)
    {
    	  $subscriptionplan1 = subscriptionplan::all();
          
    	   if(count($subscriptionplan1) > 0){

            foreach($subscriptionplan1 as $i => $value){
                $data['subscriptionplan1'][$i]['f2s_plan'] = $value->f2s_plan;
                $data['subscriptionplan1'][$i]['fans_per_event'] = $value->fans_per_event;
                $data['subscriptionplan1'][$i]['events_per_month'] = $value->events_per_month;
                $data['subscriptionplan1'][$i]['push_notification'] = $value->push_notification;
                $data['subscriptionplan1'][$i]['favorite_link'] = $value->favorite_link;
                $data['subscriptionplan1'][$i]['cost'] = $value->cost;
                $data['subscriptionplan1'][$i]['cost_value'] = $value->cost_value;
                $data['subscriptionplan1'][$i]['anual_plan'] = $value->anual_plan;
                $data['subscriptionplan1'][$i]['hardware_required'] = $value->hardware_required;
                $data['subscriptionplan1'][$i]['status'] = $value->status;
                $data['subscriptionplan1'][$i]['id'] = $value->id;
            }
            
        $response = [
            'status' => 200,
            'success' => true,
            'data'    => $data,
        ];
        return response()->json($response, 200);
        }else{
            $response = [
                'status' => 404,
                'success' => false,
                'message' => "No Data Found"
            ];
            return response()->json($response, 200);
        }
    }

     public function artistf2splanlist(Request $request)
    {
          $subscriptionplan = subscriptionplan::where('status',1)->get();
           if(count($subscriptionplan) > 0){
             $data = [];
        $totData = [];
        foreach($subscriptionplan as $value){
            $data['id']=$value->id;
            $data['f2s_plan']=$value->f2s_plan;
            $totData[]=$data;
        }
        $response = [
            'status' => 200,
            'success' => true,
            'data'    => $totData,
        ];
        return response()->json($response, 200);
        }else{
            $response = [
                'status' => 404,
                'success' => false,
                'message' => "No Data Found"
            ];
            return response()->json($response, 200);
        }
    }


    public function f2splanselect(Request $request)
    {
        $id = Auth()->user()->id;
        //dd($id);
        $plan = [
            'subscription_plan_id' => $request->subscription_plan_id,
        ];
            $planUpdate  = User::where('id',$id)->update($plan);

         $response = [
            'status_code'   => 200,
            'status'   => true,
            'message' => 'Plan assigned successfully',
        ];
        return response()->json($response, 200);     



    }


  
}
