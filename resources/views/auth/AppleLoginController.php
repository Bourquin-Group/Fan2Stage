<?php
 namespace App\Http\Controllers;

use App\Models\User;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Socialite\Two\User as OAuthTwoUser;

class AppleLoginController extends Controller
{

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function appleLogin($service,Request $request)
    {
         $request;
        $provider = 'apple';
        $token = $request->id_token;

        $socialUser = Socialite::driver($provider)->userFromToken($token);
        //print_r($socialUser);
         $socialUser->email;
        $socialId = User::where('social_id', $socialUser->id)->first();
        $user = User::where('email', $socialUser->email)->first();

        date_default_timezone_set('UTC'); 
        $current_date =  date("Y-m-d H:i:s"); 
        if($socialId)
        {
            

        $agent = new Agent();
        $browser = $agent->browser();
        $platform = $agent->platform();
            
            Auth::login($socialId);
            
            $authUser = User::where('email', $socialId->email)->first();
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

        }else if($user)
        {
            return redirect()->route('login')->with('error_message','Email ID Already Exsist');

        }else {
            $user = $this->registerAppleUser($socialUser,$provider);
            $authUser = User::where('email', $user->email)->first();

            $authToken = $authUser->createToken('MyApp')->accessToken; 
    
            return response()->json([
                'access_token' => $authToken,
                'user_id' => $authUser->id,
                
            ]);
        }
         
    

      

     


       return $data = [
            'grant_type' => 'social',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'provider' => 'apple',
            'access_token' => $token
        ];
        $request = Request::create('/oauth/token', 'POST', $data);

        $content = json_decode(app()->handle($request)->getContent());
        if (isset($content->error) && $content->error === 'invalid_request') {
            return response()->json(['error' => true, 'message' => $content->message]);
        }

        return response()->json(
            [
                'error' => false,
                'data' => [
                    'user' => $user,
                    'meta' => [
                        'token' => $content->access_token,
                        'expired_at' => $content->expires_in,
                        'refresh_token' => $content->refresh_token,
                        'type' => 'Bearer'
                    ],
                ]
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @param  OAuthTwoUser  $socialUser
     * @return User|null
     */
    protected function getLocalUser(OAuthTwoUser $socialUser): ?User
    {
        $user = User::where('email', $socialUser->email)->first();
        if (!$user) {
            $user = $this->registerAppleUser($socialUser);
        }

        return $user;
    }


    /**
     * @param  OAuthTwoUser  $socialUser
     * @return User|null
     */
    protected function registerAppleUser(OAuthTwoUser $socialUser,$service): ?User
    {
        $current_date =  date("Y-m-d H:i:s"); 
        $createUser = User::Create([
            'name' =>  request()->fullName ? request()->fullName  : 'Apple User',
            'email' => $socialUser->email,
            'social_id' => $socialUser->id,
            'social_type' => $service,
            'password' => encrypt('john123'),
            'last_login' =>  $current_date
        ]);

        
        Auth::login($createUser);

        $authUser = User::where('email', $socialUser->email)->first();

    //     $authToken = $authUser->createToken('MyApp')->accessToken; 


    //    $user = User::create(
    //         [
    //             'full_name' => request()->fullName ? request()->fullName : 'Apple User',
    //             'email' => $socialUser->email,
    //             'password' => Str::random(30), // Social users are password-less
                
    //         ]
    //     );
        return $authUser;
    }

}