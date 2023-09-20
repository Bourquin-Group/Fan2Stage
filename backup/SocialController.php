<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;
use Jenssegers\Agent\Agent;

class SocialController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('social');
        //$this->middleware('apple_sso');
       
    }
    public function redirect($service)
    {
        //dd('coming');
       // dd(Socialite::driver($service)->stateless()->redirect());
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function callback($service,Request $request)
    {
        $agent = new Agent();
        $browser = $agent->browser();
        $platform = $agent->platform();
       // dd('Browser : '.$browser.'- Platform: '.$platform);
        //dd('hi vimal');
        date_default_timezone_set('UTC'); 
        $current_date =  date("Y-m-d H:i:s"); 
       
        try {
            if ($request->isMethod('post')) {
                //dd('post');
                $user = Socialite::driver($service)->stateless()->user();
           //dd($user);
            }else{
            $user = Socialite::driver($service)->stateless()->user();
           //dd($user);
           
            $socialId = User::where('social_id', $user->id)->first();

            $socialEmail = User::where('email', $user->email)
                               // ->where('social_type',$service)
                                ->first();
            
            if($socialId)
            {
                
                Auth::login($socialId);
                
                $authUser = User::where('email', $user->email)->first();
                $authUser->last_login = $current_date;
                $authUser->save();

                $authToken = $authUser->createToken('MyApp')->accessToken; 
               

                if($browser)
                //if ($prev->segment(1) == 'api')
                {
                    return view('home');
                    //return response($authUser);
                }
                else
                {
                   // return view('home');
                    //return response($authUser);

                    return response()->json([
                        'access_token' => $authToken,
                        'user_id' => $authUser->id,
                        
                    ]);
                }
                
              

            }
            else if($socialEmail)
            {
                return redirect()->route('login')->with('error_message','Email ID Already Exsist');

            }
            else
            {

                $createUser = User::updateOrCreate([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => $service,
                    'password' => encrypt('john123'),
                    'last_login' =>  $current_date
                ]);

                
                Auth::login($createUser);

                $authUser = User::where('email', $user->email)->first();

                $authToken = $authUser->createToken('MyApp')->accessToken; 

                if($browser)
                //if ($prev->segment(1) == 'api')
                {
                    return view('home');
                  //  return response($authUser);
                }
                else
                {
                   // return view('home');
                    //return response($authUser);

                    return response()->json([
                        'access_token' => $authToken,
                        'user_id' => $authUser->id,
                        
                    ]);
                }
            }
        }

        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
    // public function appleCallback(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         dd('post');
    //         // Handle the POST request here
    //     } else {
    //         dd('get');
    //         // Handle the GET request here
    //     }
    // }
}
