<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Artist_profiles;
use App\Models\subscriptionplan;
use App\Models\Eventbooking;
use Auth;
use Session;
use Redirect;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use App\Models\Favourite;
use App\Models\Event;
use App\Models\genre;
use App\Models\timezone;
use App\Models\billinginformation;

class ArtistController extends Controller
{
    public function profile(Request $request){
        $profile = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
        $profileArray = json_decode ($profile->content(), true);
        $a_profile = $profileArray['profile'];

        $sc_event = app('App\Http\Controllers\API\SubscriptionPlanController')->subscriptionplanlist($request);
        $sc_planArray = json_decode ($sc_event->content(), true);
        $plans = $sc_planArray['data'];
        $planlist = $plans['subscriptionplan1'];

        // cms content 
        $aboutus = app('App\Http\Controllers\API\CmsManageController')->aboutus();
        $aboutusArray = json_decode ($aboutus->content(), true);
        $aboutus = $aboutusArray['data'];

        $privacypolicy = app('App\Http\Controllers\API\CmsManageController')->privacypolicy();
        $privacypolicyArray = json_decode ($privacypolicy->content(), true);
        $privacypolicy = $privacypolicyArray['data'];

        $termsandcondition = app('App\Http\Controllers\API\CmsManageController')->termsandcondition();
        $termsandconditionArray = json_decode ($termsandcondition->content(), true);
        $termsandcondition = $termsandconditionArray['data'];
        // cms content 

        return view('artistweb.profileContent',compact('a_profile','planlist','aboutus','privacypolicy','termsandcondition'));
    }
    public function editprofile(Request $request){
        $sc_event = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
        $sc_eventArray = json_decode ($sc_event->content(), true);
        $a_profile = $sc_eventArray['profile'];

        $sc_event = app('App\Http\Controllers\API\SubscriptionPlanController')->subscriptionplanlist($request);
        $sc_planArray = json_decode ($sc_event->content(), true);
        $plans = $sc_planArray['data'];
        $planlist = $plans['subscriptionplan1'];

        // cms content 
        $aboutus = app('App\Http\Controllers\API\CmsManageController')->aboutus();
        $aboutusArray = json_decode ($aboutus->content(), true);
        $aboutus = $aboutusArray['data'];

        $privacypolicy = app('App\Http\Controllers\API\CmsManageController')->privacypolicy();
        $privacypolicyArray = json_decode ($privacypolicy->content(), true);
        $privacypolicy = $privacypolicyArray['data'];

        $termsandcondition = app('App\Http\Controllers\API\CmsManageController')->termsandcondition();
        $termsandconditionArray = json_decode ($termsandcondition->content(), true);
        $termsandcondition = $termsandconditionArray['data'];
        // cms content 

        $genres = genre::get();
        $timezone = timezone::get();


        return view('artistweb.editprofile',compact('a_profile','planlist','aboutus','privacypolicy','termsandcondition','genres','timezone'));
    }
    public function artistupdate(Request $request){
        $sc_event = app('App\Http\Controllers\API\ArtistController')->updateArtist($request);
        $sc_eventArray = json_decode ($sc_event->content(), true);
        if(isset($sc_eventArray['success']) == 'true'){
            // return redirect('/web/profile');
            return redirect()->route('profile')->with('successweb', $sc_eventArray['message']);
        }else{
            return Redirect::back()->withInput();
        }
    }
    public function timezone_no(Request $request)
    {
        $artist = app('App\Http\Controllers\API\ArtistController')->timezone_no($request);
        $artistArray = json_decode ($artist->content(), true);
        $va = $artistArray['success'];
        if($va == 'true'){
            return response()->json(['status' => 1,'message'=>$artistArray['message']]);
          }
    }

    public function changepassword(Request $request){
        $validator = $this->validate($request,[
            'current_password' => 'required|string',
            'new_password' => ['required','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/'],
            'c_password' => 'required|same:new_password',
        ],[
            'current_password.required' => 'Please enter current password',
            'new_password.required' => 'Please enter new password',
            'new_password.regex' => 'Password must contains uppercase,lowercase,symbols & digits',
            'c_password.required' => 'Please enter confirm new password',
            'c_password.same' => 'Please give confirm password same as new password',
        ]);
        $auth = Auth::user();

// The passwords matches
        if (!Hash::check($request->get('current_password'), $auth->password)) 
        {
            return response()->json([
                'success' => false,
                'flag' => 1,
                'message' => 'Current Password is Invalid.',
            ]);
            // return $this->sendError('error', ['error'=>'Current Password is Invalid','co_name'=>'current_password'],401);
            //return back()->with('error', "Current Password is Invalid");
        }

// Current password and new password same
        if (strcmp($request->get('current_password'), $request->new_password) == 0) 
        {
            return response()->json([
                'success' => false,
                'flag' => 2,
                'message' => 'New Password cannot be same as your current password.',
            ]);
            // return $this->sendError('error', ['error'=>'New Password cannot be same as your current password.','co_name'=>'new_password'],403);
            //return redirect()->back()->with("error", "New Password cannot be same as your current password.");
        }

        $user =  User::find($auth->id);
        $user->password =  Hash::make($request->new_password);
        $user->save();
        return response()->json([
            'success' => true,
            'flag' => 3,
            'message' => 'Password Changed Successfully.',
        ]);
        // return $this->sendResponse('success', 'Password Changed Successfully.');
    }
    
    public function billinginformation(Request $request){
        $validator = $this->validate($request,[
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => ['required'],
            'country' => 'required',
            'postalcode' => 'required',
        ],[
            'address.required' => 'Please enter address',
            'city.required' => 'Please enter city',
            'state.required' => 'Please enter state',
            'country.required' => 'Please enter country',
            'postalcode.required' => 'Please enter postalcode',
        ]);
        $user = billinginformation::where('user_id',Auth::user()->id)->first();
        $userbilling = User::where('id',Auth::user()->id)->first();
                if($user){
                    $user->address    = $request['address'];
                    $user->city  = $request['city'];
                    $user->state         = $request['state'];
                    $user->country         = $request['country'];
                    $user->postalcode         = $request['postalcode'];
                    $user->save();

                    $userbilling->billinginfo = 1;
                    $userbilling->save();
                    return response()->json([
                        'status'    =>200,
                        'success' => true,
                        'flag' => 3,
                        'message' => 'Billing information updated successfully',
                    ]);
                }
                else{
                    $inputs = [ 
                        'user_id' => auth()->user()->id,
                        'address' => $request['address'],
                        'city' => $request['city'],
                        'state' => $request['state'],
                        'country' => $request['country'],
                        'postalcode' => $request['postalcode'],
                    ];
                        $storebillinfo = billinginformation::create($inputs);
                        if($storebillinfo){
                            $userbilling->billinginfo = 1;
                            $userbilling->save();
                            return response()->json([
                                'status'    =>200,
                                'success' => true,
                                'flag' => 3,
                                'message' => 'Billing information created successfully',
                            ]);
                        }
                }
        // return $this->sendResponse('success', 'Password Changed Successfully.');
    }
    public function followers(Request $request){
        // $sc_event = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
        // $sc_eventArray = json_decode ($sc_event->content(), true);
        // $a_profile = $sc_eventArray['profile'];

        $auth_id = Auth::user()->id;
        $followerid = Favourite::where('artist_id',$auth_id)->pluck('user_id')->toArray();
        $followerslist = User::whereIn('id',$followerid)->get();

        return view('artistweb.followers',compact('followerslist'));
    }
    public function fanslist($id){
        $id = base64_decode($id);
        // $sc_event = app('App\Http\Controllers\API\ArtistController')->artistDetail($id);
        // $sc_eventArray = json_decode ($sc_event->content(), true);
        // $a_profile = $sc_eventArray['profile'];

        $auth_id = Auth::user()->id;
        $followerid = Eventbooking::where('event_id',$id)->pluck('user_id')->toArray();
        // dd($followerid);

        $fanslist = User::whereIn('id',$followerid)->get();
        // return view('artistweb.followers');
        return view('artistweb.fanslist',compact('fanslist'));
    }

    public function userscount(Request $request,$id){
        $sc_event = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
        $sc_eventArray = json_decode ($sc_event->content(), true);
        $a_profile = $sc_eventArray['profile'];

        $auth_id = Auth::user()->id;
        $id=base64_decode($id);
        $liveuserid = Eventbooking::where('event_id',$id)->where('joinEvent_Time', '!=', NULL)->pluck('user_id')->toArray();
        // dd($liveuserid);
        $liveuserlist = User::whereIn('id',$liveuserid)->get();
        
        return view('artistweb.liveuser',compact('liveuserlist','a_profile'));
    }

    public function termscondition(Request $request){
        $auth_id = Auth::user()->id;
        $termsandcondition = app('App\Http\Controllers\API\CmsManageController')->termsandcondition();
        $termsandconditionArray = json_decode ($termsandcondition->content(), true);
        $termsandcondition = $termsandconditionArray['data'];

        return view('artistweb.termsContent',compact('termsandcondition'));
    }

    public function privacypolicy(Request $request){
        $auth_id = Auth::user()->id;
        $privacypolicy = app('App\Http\Controllers\API\CmsManageController')->privacypolicy();
        $privacypolicyArray = json_decode ($privacypolicy->content(), true);
        $privacypolicy = $privacypolicyArray['data'];

        return view('artistweb.privacyContent',compact('privacypolicy'));
    }

    public function liveevent(){
        return view('artistweb.liveevent');
    }


    

}
