<?php

namespace App\Http\Controllers;

use Auth;

use Exception;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('social');
        //$this->middleware('apple_sso');
       
    }
    public function redirect($service)
    {
        dd('coming');
       // dd(Socialite::driver($service)->stateless()->redirect());
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function callback($service,Request $request)
    {
        dd('coming');
        
        $agent = new Agent();
        $browser = $agent->browser();
        $platform = $agent->platform();
        date_default_timezone_set('UTC'); 
        $current_date =  date("Y-m-d H:i:s"); 
       //old code
        // try {
        //     if ($request->isMethod('post')) {
        //         //dd('post');
        //         $user = Socialite::driver($service)->stateless()->user();
         
        //     }else{
        //     $user = Socialite::driver($service)->stateless()->user();
           
           
        //     $socialId = User::where('social_id', $user->id)->first();

        //     $socialEmail = User::where('email', $user->email)
        //                        // ->where('social_type',$service)
        //                         ->first();
            
        //     if($socialId)
        //     {
                
        //         Auth::login($socialId);
                
        //         $authUser = User::where('email', $user->email)->first();
        //         $authUser->last_login = $current_date;
        //         $authUser->save();

        //         $authToken = $authUser->createToken('MyApp')->accessToken; 
               

        //         if($browser)
        //         //if ($prev->segment(1) == 'api')
        //         {
        //             return view('home');
        //             //return response($authUser);
        //         }
        //         else
        //         {
        //            // return view('home');
        //             //return response($authUser);

        //             return response()->json([
        //                 'access_token' => $authToken,
        //                 'user_id' => $authUser->id,
                        
        //             ]);
        //         }
                
              

        //     }
        //     else if($socialEmail)
        //     {
        //         return redirect()->route('login')->with('error_message','Email ID Already Exsist');

        //     }
        //     else
        //     {

        //         $createUser = User::updateOrCreate([
        //             'name' => $user->name,
        //             'email' => $user->email,
        //             'social_id' => $user->id,
        //             'social_type' => $service,
        //             'password' => encrypt('john123'),
        //             'last_login' =>  $current_date
        //         ]);

                
        //         Auth::login($createUser);

        //         $authUser = User::where('email', $user->email)->first();

        //         $authToken = $authUser->createToken('MyApp')->accessToken; 

        //         if($browser)
        //         //if ($prev->segment(1) == 'api')
        //         {
        //             return view('home');
        //           //  return response($authUser);
        //         }
        //         else
        //         {
        //            // return view('home');
        //             //return response($authUser);

        //             return response()->json([
        //                 'access_token' => $authToken,
        //                 'user_id' => $authUser->id,
                        
        //             ]);
        //         }
        //     }
        // }

        // } catch (Exception $exception) {
        //     dd($exception->getMessage());
        // }

        // new code for apple
        if ($request->isMethod('post')) {
            if($service == 'apple')
            { 
                $token = $request->id_token;
                $user = Socialite::driver('apple')->userFromToken($token);
               

            }else{
               return $user = Socialite::driver($service)->stateless()->user();
            }
        }else{
            if($service == 'apple')
            { 
                $token = $request->id_token;
                $user = Socialite::driver('apple')->userFromToken($token);

            }else{
                $user = Socialite::driver($service)->stateless()->user();
            }
       
        }
        $socialId = User::where('social_id', $user->id)->first();

        $socialEmail = User::where('email', $user->email)
                           // ->where('social_type',$service)
                            ->first();
        if($socialId)
        {
            
            Auth::login($socialId);
            
            $authUser = User::where('email', $user->email)->first();
            $authUser->last_login = Carbon::now();
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
                'name' => $user->name?$user->name:$service,
                'email' => $user->email,
                'social_id' => $user->id,
                'social_type' => $service,
                'password' => encrypt('john123'),
                'last_login' =>  'vimal'
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
