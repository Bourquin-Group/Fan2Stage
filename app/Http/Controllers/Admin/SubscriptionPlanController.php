<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SubscriptionPlanRequest;
use App\Models\subscriptionplan;

class SubscriptionPlanController extends Controller
{

	public function subscriptionplan(Request $request){
        $subscriptionplan = app('App\Http\Controllers\API\SubscriptionPlanController')->subscriptionplanlist($request);
        $subscription_plandataArray = json_decode ($subscriptionplan->content(), true);
       if($subscription_plandataArray['success'] == 'true'){
        $subscriptionplan = $subscription_plandataArray['data'];
        
        return view('admin.subscriptionplanlist',compact('subscriptionplan'));
       }else{
        $subscriptionplan = [];
        
        return view('admin.subscriptionplanlist',compact('subscriptionplan'));
       }
        
    }
    
    // public function subscriptionplan(Request $request)
    // {
    // 	  $subscriptionplan = subscriptionplan::all();
    // 	 //printf($data)
    // 	return view('admin.subscriptionplanlist', compact('subscriptionplan'));
    // }
     public function subscriptionplancreation(Request $request)
    {
        //$country   = country::all();
    	return view('admin.subscriptionplan_manage');
    }
     public function subscriptionplanstore(SubscriptionPlanRequest $request)
    {
        //dd($request);
        $hardware_required = implode(',',$request->hardware_required);
        $details              = [
            "f2s_plan"    => $request->f2s_plan,
            "fans_per_event"    => $request->fans_per_event,
            "events_per_month"     => $request->events_per_month,
            "push_notification"     => $request->push_notification,
            "favorite_link"         => $request->favorite_link,
            "cost"         => $request->cost,
            "cost_value"         => $request->cost_value,
            "anual_plan"         => $request->anual_plan,
            "hardware_required"         => $hardware_required,
            "status"         => ($request->has('status') == true) ? 1 : 0,
        ];
         $supplier_array        = subscriptionplan::create($details);
        return redirect('/admin/subscriptionplan')->with('Success', 'Subscription Plan Added Successfully.');
    }

        public function editsubscriptionplan($id)
    {
      
        $id             = base64_decode($id);
        $editsubscriptionplan   = subscriptionplan::where('id',$id)->first();
       // $countryselect =  User::where('id',$id)->first();
        //$country   = country::all();
        if(!$editsubscriptionplan)
        {
            return redirect('/admin/subscriptionplan')->with('Error','Setting id is not available');
        }
       
        return view('admin.subscriptionplan_edit', compact('editsubscriptionplan'));
    }
    public function updatesubscriptionplan(SubscriptionPlanRequest $request, $id)
    {
        $hardware_required = implode(',',$request->hardware_required);
        $details              = [
          "f2s_plan"    => $request->f2s_plan,
            "fans_per_event"    => $request->fans_per_event,
            "events_per_month"     => $request->events_per_month,
            "push_notification"     => $request->push_notification,
            "favorite_link"         => $request->favorite_link,
            "cost"         => $request->cost,
            "cost_value"         => $request->cost_value,
            "anual_plan"         => $request->anual_plan,
            "hardware_required"         => $hardware_required,
            "status"         => ($request->has('status') == true) ? 1 : 0,
          
        ];
//dd(  $details );
        $subscriptionplanUpdate  = subscriptionplan::where('id',$id)->update($details);
        if(!$subscriptionplanUpdate)
        {
            return redirect('/admin/subscriptionplan')->with('Error','Subscription Plan not updated');
        }
        return redirect('/admin/subscriptionplan')->with('Success','Subscription Plan Updated Sucessfully');
    }
}
