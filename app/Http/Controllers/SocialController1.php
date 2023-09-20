<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;

class SocialController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('social');
       
    }
    public function redirect($service)
    {
        //dd('coming');
       // dd(Socialite::driver($service)->stateless()->redirect());
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function callback($service,Request $request)
    {
        //dd('hi vimal');
     $token = $request->token;
        date_default_timezone_set('UTC'); 
        $current_date =  date("Y-m-d H:i:s"); 
       
        try {
            if ($request->isMethod('post')) {
                $user = Socialite::driver($service)->stateless()->user();
           // dd($request->access_token);
           dd($user);
            }else{
            $user = Socialite::driver($service)->stateless()->user();
           dd($user);
           
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
                
                return view('home');

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

                return view('home');
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
