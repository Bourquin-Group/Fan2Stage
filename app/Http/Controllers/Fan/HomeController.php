<?php

namespace App\Http\Controllers\Fan;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Artist_profiles;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\genre;
use App\Models\timezone;
use Session;

class HomeController extends Controller
{
    public function homepage(Request $request){
        $timezone_region = timezone::where('timezone',Session::get('user_timezone'))->first();
        // dd(Session::get('user_timezone'));
        if(Session::get('user_timezone')){
        date_default_timezone_set($timezone_region['region']);
        }
        
        $artist = app('App\Http\Controllers\API\ArtistController')->allArtist($request);
        $artistArray = json_decode ($artist->content(), true);
        $artist_profile = $artistArray['data'];
        
        $liveevent = app('App\Http\Controllers\API\EventController')->liveEventList($request);
        $liveeventArray = json_decode ($liveevent->content(), true);
        $liveevent_data = $liveeventArray['data'];
        
        $scheduleevent = app('App\Http\Controllers\API\EventController')->scheduledEventList($request);
        $scheduleeventArray = json_decode ($scheduleevent->content(), true);
        $scheduleevent_data = $scheduleeventArray['data'];

        return view('fanweb.dashboard',compact('artist_profile','liveevent_data','scheduleevent_data'));
        
    }

    public function showliveevent(Request $request){
        $liveevent = app('App\Http\Controllers\API\EventController')->liveEventList($request);
        $liveeventArray = json_decode ($liveevent->content(), true);
        $liveevent_data = $liveeventArray['data'];

        return view('fanweb.showliveevent',compact('liveevent_data'));
    }
    public function showscheduleevent(Request $request){
        $scheduleevent = app('App\Http\Controllers\API\EventController')->scheduledEventList($request);
        $scheduleeventArray = json_decode ($scheduleevent->content(), true);
        $scheduleevent_data = $scheduleeventArray['data'];

        return view('fanweb.showscheduleevent',compact('scheduleevent_data'));
    }
    public function newsletter(Request $request){
        $newsletter = app('App\Http\Controllers\API\NewsletterController')->newscreate($request);
        $newsletterArray = json_decode ($newsletter->content(), true);
        if($newsletterArray['success'] == 'true'){
            Session::flash('success', $newsletterArray['message']);
            return redirect()->back();
            // return redirect('/fan/fanhome');
        }else{
            return Redirect::back()->withInput();
        }
    }

    public function liveEvent($id)
    {
        $id = base64_decode($id);
        $liveevent = app('App\Http\Controllers\API\EventController')->eventshow($id);
        $liveeventArray = json_decode ($liveevent->content(), true);
         $event = $liveeventArray['data'];
        return view('fanweb.live-event',compact('event'));
        
    }
    public function scheduledEvent($id)
    {
        $id = base64_decode($id);
        $liveevent = app('App\Http\Controllers\API\EventController')->eventshow($id);
        $liveeventArray = json_decode ($liveevent->content(), true);
         $event = $liveeventArray['data'];
            $shareButton = \Share::page(
                // \Redirect::route('scheduled-event', base64_encode($event['event_id'])),
                'https://www.youtube.com/watch?v=fa-c2fY_tOQ',
                // url('/fan/scheduled-event/'.base64_encode($event['event_id'])),
                'Enjoy Our Event',
            )
            ->facebook()
            ->whatsapp()
            ->linkedin();

        return view('fanweb.scheduled-event',compact('event','shareButton'));
    }

    public function editProfile(Request $request)
    {

        $sc_event = app('App\Http\Controllers\API\ArtistController')->artistDetail($request);
        $sc_eventArray = json_decode ($sc_event->content(), true);
        $a_profile = $sc_eventArray['profile'];
        
        $profile = app('App\Http\Controllers\API\AuthController')->viewProfile($request);
        $profileArray = json_decode ($profile->content(), true);
        $profile = $profileArray['data'];

        $getbillinfo = app('App\Http\Controllers\API\AuthController')->getbillinfo($request);
        $getbillinfoArray = json_decode ($getbillinfo->content(), true);
        $getbillinfo = $getbillinfoArray['data'];

        $date_format ='';
        if($profile['dob'])
        {
            $date_format1 = Carbon::createFromFormat('Y-m-d', $profile['dob']);
            $date_format = Carbon::parse($date_format1)->format('d/m/Y'); 
        }

        $genres = genre::get();
        $timezone = timezone::get();
     
        return view('fanweb.profile.edit-profile',compact('profile','date_format','getbillinfo','genres','timezone','a_profile'));
    }

    public function profileStore(Request $request)
    {
        $artist = app('App\Http\Controllers\API\AuthController')->updateProfile($request);
        $artistArray = json_decode ($artist->content(), true);
        $va = $artistArray['success'];
        if($va == 'true'){
            return response()->json(['status' => 1,'message'=>$artistArray['message']]);
          }else{
            if(isset($artistArray['flag']) == 1){
              return response()->json(['status' => 0,'message' => $artistArray['message'], 'flag' => $artistArray['flag']]);
            }else{
            return response()->json(['status' => 0, 'message' => $artistArray['error']]);
            }
        }
        // if($artistArray['success'] =='true')
        // {
        //   Session::flash('success1', $artistArray['message']);
        // }
        // else{
        // $login = [];
        // Session::flash('error', $artistArray['message']);
        // }
        // return redirect('/fan/edit-profile');
    }

    public function about()
    {
        $aboutus = app('App\Http\Controllers\API\CmsManageController')->aboutus();
        $aboutusArray = json_decode ($aboutus->content(), true);
        $aboutus = $aboutusArray['data'];
        return view('fanweb.profile.about',compact('aboutus'));
    }

    public function term()
    {
        $auth_id = Auth::user()->id;
        $termsandcondition = app('App\Http\Controllers\API\CmsManageController')->termsandcondition();
        $termsandconditionArray = json_decode ($termsandcondition->content(), true);
        $termsandcondition = $termsandconditionArray['data'];
        return view('fanweb.profile.term',compact('termsandcondition'));
    }

    public function privacy()
    {
        $auth_id = Auth::user()->id;
        $privacypolicy = app('App\Http\Controllers\API\CmsManageController')->privacypolicy();
        $privacypolicyArray = json_decode ($privacypolicy->content(), true);
        $privacypolicy = $privacypolicyArray['data'];
        return view('fanweb.profile.privacy',compact('privacypolicy'));
    }

    public function favorites()
    { 
        $favorties = app('App\Http\Controllers\API\FavouritesController')->listFavourite();
        $favortiesArray = json_decode ($favorties->content(), true);
        $favorties = $favortiesArray['data'];
        return view('fanweb.profile.favorites',compact('favorties'));
    }

    public function premium()
    {
        return view('fanweb.profile.premium');
    }

    public function changePassword(Request $request)
    {
        $favorties = app('App\Http\Controllers\API\AuthController')->changePassword($request);
        $favortiesArray = json_decode ($favorties->content(), true);
        if($favortiesArray['success'] =='true')
        {
          Session::flash('success', $favortiesArray['message']);
        }
        else{
        $login = [];
        Session::flash('error', $favortiesArray['message']);
        }
        return redirect()->back();
    }
    public function changePasswordfan(Request $request){
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
            
        }

// Current password and new password same
        if (strcmp($request->get('current_password'), $request->new_password) == 0) 
        {
            return response()->json([
                'success' => false,
                'flag' => 2,
                'message' => 'New Password cannot be same as your old password.',
            ]);
            
        }

        $user =  User::find($auth->id);
        $user->password =  Hash::make($request->new_password);
        $user->save();
        return response()->json([
            'success' => true,
            'flag' => 3,
            'message' => 'Password Changed Successfully.',
        ]);
    }
    

    public function advanceSearch(Request $request)
    {
        //If empty params then redirect to page
        if (count($request->all())== 0) {   
            return redirect()->route('fanhome');
        }
        if($request->ad_genre_checkbox && $request->ad_genre)
        {
            $genre = explode(',',$request->ad_genre);
            $request->merge(['genre' => $genre]);
        }
        if($request->ad_rating_checkbox && $request->ad_rating_value)
        {
            $rating = explode(',',$request->ad_rating_value);
            $request->merge(['rating' => $rating]);
        }
        if($request->ad_date != NULL){
            $request->merge(['from_date' => $request->ad_from_date]);
            $request->merge(['to_date' => $request->ad_to_date]);
        }
        $request->merge(['type' => $request->ad_type]);
        $request->merge(['name' => $request->ad_search]);
        if($request->ad_type == 'artists')
        {
            // dd($request);
            $filter = app('App\Http\Controllers\API\ArtistfilterController')->artistFilter($request);
            $filtersArray = json_decode ($filter->content(), true);
            $advanceSearch = $filtersArray['data'];
            return view('fanweb.advance-search',compact('advanceSearch','request'));
        }else{
            $filter = app('App\Http\Controllers\API\EventfilterController')->eventFilter($request);
            $filtersArray = json_decode ($filter->content(), true);
            $advanceSearch = $filtersArray['data'];
            return view('fanweb.eventsearch',compact('advanceSearch','request'));
        }
    
    }


    public function favoritesUpdate(Request $request)
    {
        $type = $request->type;
       
        $filter = app('App\Http\Controllers\API\FavouritesController')->addFavourite($request);
        $filtersArray = json_decode ($filter->content(), true);
        // dd($filtersArray);
        if($type ==1)
            //  return redirect()->back();
            return response()->json($filtersArray);
        else{
            return $this->advanceSearch($request);
        }
        
   
    }

    public function editbillinginfo(Request $request)
    {
        $profile = app('App\Http\Controllers\API\AuthController')->getbillinfo($request);
        $profileArray = json_decode ($profile->content(), true);
        $profile = $profileArray['data'];
        return view('fanweb.profile.edit-profile',compact('profile'));
    }

    public function billinginfo(Request $request)
    {
        $artist = app('App\Http\Controllers\API\AuthController')->storebillinginfo($request);
        $artistArray = json_decode ($artist->content(), true);
        if($artistArray['success'] =='true')
        {
          Session::flash('billsuccess', $artistArray['message']);
        }
        else{
        $login = [];
        Session::flash('billerror', $artistArray['message']);
        }
        return redirect('/fan/edit-profile');
    }

    public function socket(){
        return view('fanweb.socket_testing');
    }
}