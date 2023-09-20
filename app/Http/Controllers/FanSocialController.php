<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FanSocialController extends Controller
{
    public function redirect($service)
    {
        return app('App\Http\Controllers\API\AuthController')->socialRedirect($service);
    }

    public function callback($service,Request $request)
    {
        $result = app('App\Http\Controllers\API\AuthController')->socialLogin($service,$request);
        $login_dataArray = json_decode ($result->content(), true);
        if(isset($login_dataArray['success']) && $login_dataArray['success'] == 'true'){
            return redirect('fan/fanhome');
        }
        else{
            Session::flash('message', $changepassword_dataArray['error']);
           return redirect()->back();
        }
        
        // $agent = new Agent();
        // $browser = $agent->browser();
        // $platform = $agent->platform();
        // date_default_timezone_set('UTC'); 
        // $current_date = carbon::now(); 
        // // new code for apple
        // if ($request->isMethod('post')) {
        //     if($service == 'apple')
        //     { 
        //         $token = $request->id_token;
        //         $user = Socialite::driver('apple')->userFromToken($token);
        //     }else{
        //         $user = Socialite::driver($service)->stateless()->user();
        //     }
        // }else{
        //     if($service == 'apple')
        //     { 
        //         $token = $request->id_token;
        //         $user = Socialite::driver('apple')->userFromToken($token);

        //     }else{
        //         $user = Socialite::driver($service)->stateless()->user();
        //     }
       
        // }
        // $socialId = User::where('social_id', $user->id)->first();

        // $socialEmail = User::where('email', $user->email)->first();
        // if($socialId)
        // {
        //     Auth::login($socialId);
        //     $authUser = User::where('email', $user->email)->first();
        //     $authUser->last_login = $current_date;
        //     $authUser->save();
        //     $authToken = $authUser->createToken('MyApp')->accessToken; 
        //     if($browser)
        //     {
        //         return view('home');
        //         //return response($authUser);
        //     }
        //     else
        //     {
        //         return response()->json([
        //             'access_token' => $authToken,
        //             'user_id' => $authUser->id,
        //         ]);
        //     }
        // }
        // else if($socialEmail)
        // {
        //     return redirect()->route('login')->with('error_message','Email ID Already Exsist');
        // }
        // else
        // {

        //     $createUser = User::updateOrCreate([
        //         'name' => $user->name?$user->name:$service,
        //         'email' => $user->email,
        //         'social_id' => $user->id,
        //         'social_type' => $service,
        //         'password' => encrypt('john123'),
        //         'last_login' =>  $current_date
        //     ]);
        //     Auth::login($createUser);
        //     $authUser = User::where('email', $user->email)->first();
        //     $authToken = $authUser->createToken('MyApp')->accessToken; 
        //     if($browser)
        //     {
        //         return view('home');
        //     }
        //     else
        //     {
        //         return response()->json([
        //             'access_token' => $authToken,
        //             'user_id' => $authUser->id,
                    
        //         ]);
        //     }
        // }
    }
}
