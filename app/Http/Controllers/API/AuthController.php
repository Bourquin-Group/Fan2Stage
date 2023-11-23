<?php

namespace App\Http\Controllers\API;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\RegisteredUser;
use Illuminate\Http\Request;
use App\Models\Artist_profiles;
use App\Models\subscriptionplan;
use App\Models\billinginformation;
use App\Models\Newsletters;
use App\Models\timezone_change;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use Laravel\Socialite\Facades\Socialite;
use Jenssegers\Agent\Agent;
use Session;
use Newsletter;

class AuthController extends BaseController
{
    //f
    public function register(Request $request)
    {
        $validator =$this->validate($request,[

                'full_name' => ['required','string','regex:/^[a-z|A-Z]+(?: [a-z|A-Z]+)*$/'],
                // 'last_name' => ['required','string','regex:/^[a-z|A-Z]+(?:( |-)[a-z|A-Z]+)*$/'],
                //  'country_code' => ['required','regex:/^\+\d{1,2}$/'],
                'phone_number' => ['required'],
                // 'phone_number' => ['required','numeric','digits:10'],
                //'email' => 'required|email|unique:users',
                'email' => ['required', 'regex:/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/i', 'unique:users'],
                'password' => ['required','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/'],
                'c_password' => 'required|same:password',
                'accept'=>'required',
            ],
            [
                'full_name.required'=> 'Please enter your name',
                'full_name.regex'=> 'Full Name format is invalid',
                'phone_number.required'=> 'Please enter your phone number',
                'phone_number.digits'=> 'Phone number must be 10 digits',
                'phone_number.numeric'=> 'A phone number must have digits.',
                'email.required'=> 'Please enter your email',
                'email.regex'=> 'Invalid email address',
                'email.unique'=> 'This email already registered ',
                'password.required'=> 'Enter your password',
                'password.regex'=> 'Password require uppercase,lowercase,symbols & digits',
                'c_password.required'=> 'Please enter the confirm password',
                'c_password.same'=> 'Confirm password must be same as password',
                'accept.required'=> 'Please accept the term and condition',
            ]
        );

            $request['name']   = $request['full_name'];
            // for otp
            $otp = rand(1000,9999);
            $now = time();
            $ten_minutes = $now + (2 * 60);
            $startDate = date('Y-m-d H:i:s', $now);
            $expiretime = date('Y-m-d H:i:s', $ten_minutes);
            // for otp
            $input = $request->all();
            $input['user_type'] = $request->user_type;
            $input['password'] = bcrypt($input['password']);

            // Fan user start
            if($request->user_type =='users')
            {
                $user              = User::create($input);
                $user->name        = $request->full_name;
                $user->timezone        = 1;
                $user->save();
                $success['token']  = $user->createToken('MyApp')->accessToken;
                $success['name']   = $user->name;
                $success['id']   = $user->id;
                $success['uuid']   = $user->uuid;
                $email = $user->email;
                $data = array(
                    'name' => $user->name,
                );
                Mail::send('mail.register',$data,function($message) use($email){
                    $message->to($email);
                    $message->subject('Congratulations');
                    });
                return $this->sendResponse($success, 'User register successfully.');
            }
            // Fan user end

            $user1 = User::where('email',$request->email)->where('password_otp','!=',Null)->first();
            if(isset($user1)){
                $user_details['name']      = $request->full_name;
                $user_details['password_otp']      = $otp;
                $user_details['otp_expire_time']   = $expiretime;
                $user_details['name'] = $request->full_name;
                $user_details['country_code'] = $request->country_code;
                $user_details['email'] = $request->email;
                $user_details['password'] = $request->full_name;
                $user_details['user_type'] = $request->user_type;

                $userUpdate  = User::where('email',$request->email)->update($user_details);
                $success['token']  = $user1->createToken('MyApp')->accessToken;
                $success['name']   = $user1->name;
                $email             = $user1->email;
                $success['uuid']   = $user1->uuid;
                $data = array(
                    'name' => $request->full_name,
                    'otp'  => $otp
                );
            }
            else{
                $user2 = User::where('email',$request->email)->where('password_otp',Null)->first();
                if(isset($user2))
                {

                    $validator =$this->validate($request,[

                    'email' => 'unique:users',
                    
                    ],
                    [
                    
                    'email.unique'=> 'This Email Already Registered ',
                    
                    ]
                    );
                }
                else{
                        $user = User::create($input);
                        $user->name        = $request->full_name;
                        if($request->user_type != 'users'){
                            $user->password_otp        = $otp;
                            $user->otp_expire_time     = $expiretime;
                        }
                        $user->save();
                        $success['token']  = $user->createToken('MyApp')->accessToken;
                        $success['name']   = $user->name;
                        $email             = $user->email;
                        $success['uuid']   = $user->uuid;
                        $data = array(
                            'name' => $user->name,
                            'otp'  => $otp
                        );
                        $inputs = [ 
                            'user_id' => $user->id,
                        ];
                        $Artist = Artist_profiles::create($inputs);
                        
                }
            }

            Mail::send('mail.registered-user-mail',$data,function($message) use($email){
            $message->to($email);
            $message->subject('Congratulations');
            });

            // Mail::to($email)->send(new RegisteredUser($data));

            return $this->sendResponse($success, 'User register successfully.');  

    }

    public function login(Request $request)
            {
                $validator =$this->validate($request,[
                    'email' => ['required', 'regex:/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/i'],
                    'password' => 'required',
                    
                ],
                [
                   
                    'email.required'=> 'Please enter your email',
                    'email.regex'=> 'Invalid email address',
                    'password.required'=> 'Enter your password',
                ]
            );
                $pass_word = User::where('email',$request->email)->first();
                if($pass_word){
                if($pass_word->password_otp =='' || $pass_word->password_otp == null ){
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password]) || Auth::attempt(['phone_number' => $request->email, 'password' => $request->password]) ){ 
                    $user = Auth::user(); 
                    $success['token']  =  $user->createToken('MyApp')->accessToken; 
                    $success['name']   =  $user->name;
                    $success['id']   =  $user->id;
                    $success['timezone']   =  $user->timezone;
                    $success['subscription_plan_id']   =  $user->subscription_plan_id;
                    $f2splan = subscriptionplan::where('id',$user->subscription_plan_id)->first();
                    if(isset($f2splan->f2s_plan)){
                    $success['subscription_plan_name']   =  $f2splan->f2s_plan;
                    }

                    return $this->sendResponse($success, 'User login successfully.');
                } 
                else{ 
                    return response()->json([
                        'status'   => 401,
                        'success' => false,
                        'message' => 'Invalid User',
                    ],401);
                } 
            }
            else{
                return $this->sendError('notverified', ['error'=>'You are not verified user']);
            }
        }
        else{
            return response()->json([
                'status'   => 401,
                // 'flag'   => 1,
                'success' => false,
                'message' => 'Your Email Is Not Existing',
                // 'data' => $event
            ],401);
        }
            }

    public function changePassword(Request $request)
            {
                    // $this->validate($request, [
                    //     'current_password' => 'required|string',
                    //     'new_password' => ['required','confirmed','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/']
                    // ]);

                    $validator = $this->validate($request,[
                        'current_password' => 'required|string',
                        'new_password' => ['required','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/'],
                        'c_password' => 'required|same:new_password',
                    ],[
                        'current_password.required' => 'Please enter current password',
                        'new_password.required' => 'Please enter new password',
                        'new_password.regex' => 'Password must contains uppercase,lowercase,symbols & digits',
                        'c_password.required' => 'Please enter confirm password',
                        'c_password.same' => 'Please give confirm password same as new password',
                    ]);
     
                    // if($validator->fails()){
                    //     return $this->sendError('Validation Error.', $validator->errors());       
                    // }
                    $auth = Auth::user();
            
            // The passwords matches
                    if (!Hash::check($request->get('current_password'), $auth->password)) 
                    {
                        return $this->sendError('error', ['error'=>'Current Password is Invalid','co_name'=>'current_password'],401);
                        //return back()->with('error', "Current Password is Invalid");
                    }
            
            // Current password and new password same
                    if (strcmp($request->get('current_password'), $request->new_password) == 0) 
                    {
                        return $this->sendError('error', ['error'=>'New Password cannot be same as your current password.','co_name'=>'new_password'],403);
                        //return redirect()->back()->with("error", "New Password cannot be same as your current password.");
                    }
            
                    $user =  User::find($auth->id);
                    $user->password =  Hash::make($request->new_password);
                    $user->save();
                    return $this->sendResponse('success', 'Password Changed Successfully.');
                    //return back()->with('success', "Password Changed Successfully");
            }
            // mycode vimal
            public function resendotp(Request $request){ //this for artist resend otp

                $validator =$this->validate($request,[
                    'email' => ['required','regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'],
                    
                ],
                [
                    'email.required'=> 'Please Enter Your EMail',
                    'email.regex'=> 'Invalid Email Address',
                    'email.unique'=> 'This Email Already Registered ',
                   ]
            );
                $to = $request->email;

                $mail = $to;
                // $mailtemplate = new Forgotmail;
                $otp = rand(1000,9999);
                // Log::info("password_otp = ".$otp);
                $user  = User::where('email',$request->email)->first();
                if($user){
                $data=array('name'=>$user->name,'link'=>'changepassword','mail'=>$mail,'otp'=>$otp);
                $now = time();
                $ten_minutes = $now + (2 * 60);
                $startDate = date('Y-m-d H:i:s', $now);
                $expiretime = date('Y-m-d H:i:s', $ten_minutes);
                // store otp
                $user1 = User::where('email','=',$request->email)->update(['password_otp' => $otp, 'otp_expire_time' =>$expiretime]);
                if($user1){
                Mail::send('mail.resendmail',$data,function($message) use($mail){
                    $message->to($mail);
                    $message->subject('Fan2Stage OTP Verification');
                });
        
                $success['status'] = 200;
                $success['success'] = true;
                 $success['uuid']   = $user->uuid;
                 $success['email']   = $user->email;
                return $this->sendResponse($success, 'Otp sent to your email.');
            }else{
                return response(["status" => 401, 'message' => 'Invalid']);
            }
            }
            else{
                return response(["status" => 401, 'message' => 'This Email Address is Not Registered']);
            }
            }
            public function forgotpassword(Request $request){

                $validator =$this->validate($request,[
                    'email' => ['required','regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'],
                    
                ],
                [
                    'email.required'=> 'Please Enter Your EMail',
                    'email.regex'=> 'Invalid Email Address',
                    'email.unique'=> 'This Email Already Registered ',
                   ]
            );
                $to = $request->email;

                $mail = $to;
                // $mailtemplate = new Forgotmail;
                $otp = rand(1000,9999);
                // Log::info("password_otp = ".$otp);
                $user  = User::where('email',$request->email)->first();
                if($user){
                $data=array('name'=>$user->name,'link'=>'changepassword','mail'=>$mail,'otp'=>$otp);
                $now = time();
                $ten_minutes = $now + (2 * 60);
                $startDate = date('Y-m-d H:i:s', $now);
                $expiretime = date('Y-m-d H:i:s', $ten_minutes);
                // store otp
                $user1 = User::where('email','=',$request->email)->update(['password_otp' => $otp, 'otp_expire_time' =>$expiretime]);
                if($user1){
                Mail::send('mail.forgotmail',$data,function($message) use($mail){
                    $message->to($mail);
                    $message->subject('Fan2Stage OTP Verification');
                });
        
                $success['status'] = 200;
                $success['success'] = true;
                 $success['uuid']   = $user->uuid;
                 $success['email']   = $user->email;
                return $this->sendResponse($success, 'Otp sent to your email.');
            }else{
                return response(["status" => 401, 'message' => 'Invalid']);
            }
            }
            else{
                return response(["status" => 401, 'message' => 'This Email Address is Not Registered']);
            }
            }
        
            public function verifyOtp(Request $request){

                $user  = User::where('email',$request->email)->first();
                //$authid = Auth::user()->id;
                //$user  = User::where('id',$authid)->first();
                $now = time();
                $startDate = date('Y-m-d H:i:s', $now);
                if($startDate <= $user->otp_expire_time){
                $user  = User::where([['email','=',$user->email],['password_otp','=',$request->otp]])->first();
                
                if($user){
                    
                    $users = User::where('email','=',$request->email)->update(['password_otp' => null ,'otp_expire_time' =>null]);
                    $success['status'] = 200;
                    $success['mail'] = $user->email;
                    $success['flag'] = true;
                    return $this->sendResponse($success, 'OTP Verified Successfully');
                    }
                else{
                    return response(["status" => 401, 'message' => 'Invalid Otp']);
                }
            }
                else{
                    return response(["status" => 401, 'message' => 'Time expired']);
                }
            }
        
            public function restMail(Request $request){
                $mail = Crypt::decryptString($request->mail);
                $success['Mail']= $mail;
                return $this->sendResponse($success, 'Reset password Email send successfully.');
            }
        
            public function resetPassword(Request $request){
                $validator = $this->validate($request, [
                    // 'email' => 'required|email|exists:users',
                    'password' => ['required','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/'],
                    'c_password' => 'required|same:password',
                ],[
                    'password.required' => 'Please enter passowrd',
                    'password.regex' => 'Password must contains uppercase,lowercase,symbols & digits',
                    'c_password.required' => 'Please enter confirm passowrd',
                    'c_password.same' => 'Password and confirm password must be same',
                ]);
           
                // if($validator->fails()){
                //     return response()->json([
                //         'success' => 'false',
                //         'message' => 'Invalid params passed', // the ,message you want to show
                //           'errors' => $validator->errors()
                //       ], 422);       
                // }

                $user  = User::where('email',$request->email)->first();
                $current_password = $request->password;
                $user_password = $user->password;
                if (Hash::check($current_password, $user_password)){
                    return response(["success" => false, 'message' => 'Current password and New password are same.','flag' => 1]);
                }else{
                    if ($user) {
                        User::where('email', $user->email)
                            ->update(['password' => bcrypt($request->password)]);
                            $success['newpassword'] = $request->password;
                        return $this->sendResponse($success,'Reset password successfully.');
                    }
                    else {
                        return response(["success" => false, 'message' => 'Give valid mail.','flag' => 1]);
                    }
                }
                
                
            }
            // mycode vimal

    public function viewProfile(Request $request)
            {
                $user = Auth::user();
                $f2splan = subscriptionplan::where('id',$user->subscription_plan_id)->first();
                $data = [];
                if($user){
                    $data['id']     = $user->id;
                    $data['name']     = $user->name;
                    $data['email']          = $user->email;
                    $data['phone_number']   = $user->phone_number;
                    $data['timezone']   = ($user->timezone != NULL) ? $user->timezone : null;
                    $data['countrycode']   = ($user->country_code != NULL) ? $user->country_code : null;
                    $data['preferred_genre']   =($user->preferred_genre != NULL) ? explode(',',$user->preferred_genre) : null;
                    $data['dob']   = $user->dob;
                    $data['newsletter']   = $user->newsletter;
                    $data['socialimage']   = $user->image;
                    $data['profile_image']   = url('').'/fans_profile_images/'.$user->image;
                    $data['verified_profile']   = ($user->verified_profile == 1) ? true : false;
                    $response = [
                        'status'    =>200,
                        'success'   => true,
                        'message'   => 'Fans Profile Retrived Successfully',
                        'data'      => $data,
                    ];
                    return response()->json($response, 200);   
                } 
                else{ 
                    return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
                } 
            }

    public function updateProfile(Request $request)
            {
                // $validation = [
                //     'name' => ['required','string','regex:/^[a-z|A-Z]+(?: [a-z|A-Z]+)*$/'],
                //     'phone_number' => ['required','numeric','digits:10'],
                //     'email' => ['required','regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'],
                //     'dob' => 'required',
                //     'preferred_genre' => 'required',
                //     // 'countrycode' => 'required',
                // ];
                $user = User::where('id',Auth::user()->id)->first();
                if(!$user->image || $user->image == null){
                    $validator = Validator::make($request->all(),
                [
                    'name' => ['required','string','regex:/^[a-z|A-Z]+(?: [a-z|A-Z]+)*$/'],
                    'phone_number' => ['required'],
                    // 'phone_number' => ['required','numeric','digits:10'],
                    'email' => ['required','regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'],
                    'dob' => 'required',
                    'preferred_genre' => 'required',
                    'timezone' => 'required',
                    'image' => 'required',
                    // 'countrycode' => 'required',
                ],
                            [
                                'name.required' => 'Please enter the name',
                                'name.string' => 'Please type only string',
                                'phone_number.required' => 'Please enter the phone number',
                                'phone_number.numeric' => 'Please type only digits',
                                'phone_number.digits' => 'Phone number must be 10 digits',
                                'email.required' => 'Please enter the email',
                                'email.regex' => 'Invalid email address',
                                'image.required' => 'Please upload the profile image',
                                'dob.required' => 'Please enter the data of birth',
                                'preferred_genre.required' => 'Please give the preferred genre',
                                'timezone.required' => 'Please select the timezone',
                                // 'countrycode.required' => 'Please give the countrycode',
                            ]);
                //     $profileimage_validation = ['image' => 'required'];
                //     $validation = array_merge($validation, $profileimage_validation);
                }else{
                    $validator = Validator::make($request->all(),
                [
                    'name' => ['required','string','regex:/^[a-z|A-Z]+(?: [a-z|A-Z]+)*$/'],
                    'phone_number' => ['required'],
                    // 'phone_number' => ['required','numeric','digits:10'],
                    'email' => ['required','regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'],
                    'dob' => 'required',
                    'preferred_genre' => 'required',
                    'timezone' => 'required',
                    // 'countrycode' => 'required',
                ],
                            [
                                'name.required' => 'Please enter the name',
                                'name.string' => 'Please type only string',
                                'phone_number.required' => 'Please enter the phone number',
                                'phone_number.numeric' => 'Please type only digits',
                                'phone_number.digits' => 'Phone number must be 10 digits',
                                'email.required' => 'Please enter the email',
                                'email.regex' => 'Invalid email address',
                                'dob.required' => 'Please enter the data of birth',
                                'preferred_genre.required' => 'Please give the preferred genre',
                                'timezone.required' => 'Please select the timezone',
                                // 'countrycode.required' => 'Please give the countrycode',
                            ]);

                }
                
                            if($validator->fails()){
                                return response()->json(['success' => false, 'error' => $validator->errors()->toArray()]);
                            }
                            // dd($user);
                    if($user){
                    $file = $request->file('image');
                    if($file){
                        $fileName = $file->getClientOriginalName();
                        $destinationPath = public_path().'/fans_profile_images' ;
                        $file->move($destinationPath,$fileName);
                        $old_path =public_path('/fans_profile_images/'.$user->image);
                        if(File::exists($old_path) && $user->image) {
                            unlink($old_path);
                        }
                    }else{
                        $fileName = $user->image;
                    }
                    if($request['newsletter'] !=null){
                        // dd($request['email']);
                        if(! Newsletter::isSubscribed($request['email'])){
                            $check = Newsletter::subscribe($request['email']);
                            $newsletter = 1;
                        }
                        $newsletter = 1;

                    }else{
                        $emailexist = Newsletters::where('email',$request['email'])->first();
                        if($emailexist){

                            $emailexist->delete();
                            $newsletter = 0;
                        }else{
                            $newsletter = 0;
                        }
                        
                        
                    }
                    
                    $genre = array_filter($request['preferred_genre']);
                    $user->name    = $request['name'];
                    $user->phone_number  = $request['phone_number'];
                    $user->country_code  = $request['countrycode'];
                    $user->email         = $request['email'];
                    $user->image         = $fileName;
                    $user->dob         = $request['dob'];
                    $user->newsletter         = $newsletter;
                    $user->preferred_genre    = (count($genre) > 0 ) ? implode(',',$request['preferred_genre']) : NULL;
                    $user->timezone         = $request['timezone'];
                    $user->verified_profile = 1;
                    $user->save();
                    Session::put('user_timezone', $request['timezone']);

                    // update day light time change
                    if($request['timezone'] != null){
                        $timezone_date = timezone_change::where('user_id',Auth::user()->id)->first();
                        $effectiveDate = date('Y-m-d');
                        if($timezone_date){
                            $timezone_date->modify_date = date('Y-m-d', strtotime("+3 months", strtotime($effectiveDate)));
                            $timezone_date->status = 1;
                            $timezone_date->save();
                            Session::put('timezonechange', "yes");
                        }else{
                            $inputsss = [
                                'status' => 1,
                                'modify_date' => date('Y-m-d', strtotime("+3 months", strtotime($effectiveDate))),
                                'user_id' => auth()->user()->id
                            ];
                            timezone_change::create($inputsss);
                            Session::put('timezonechange', "yes");
                        }
                        
                    }
                    // update day light time change
                    return response()->json([
                        'status'    =>200,
                        'success' => true,
                        'message' => 'Profile updated successfully',
                    ]);
                }
                else{
                    return response()->json([
                        'status'    =>404,
                        'success' => false,
                        'message' => 'Profile Not Updated Successfully',
                    ]);
                }
            }
            public function timezone_no(Request $request){
                        $timezone_date = timezone_change::where('user_id',Auth::user()->id)->first();
                        $effectiveDate = date('Y-m-d');
                        if($timezone_date){
                            $timezone_date->modify_date = date('Y-m-d', strtotime("+1 months", strtotime($effectiveDate)));
                            $timezone_date->status = 0;
                            $timezone_date->save();
                            Session::put('timezonechange', true);
                            return response()->json([
                                'status'    =>200,
                                'success' => true,
                                'message' => 'timezone change successfully',
                            ]);

                        }else{
                            $inputsss = [
                                'status' => 0,
                                'modify_date' => date('Y-m-d', strtotime("+1 months", strtotime($effectiveDate))),
                                'user_id' => auth()->user()->id
                            ];
                            timezone_change::create($inputsss);
                            Session::put('timezonechange', true);
                            return response()->json([
                                'status'    =>200,
                                'success' => true,
                                'message' => 'timezone change successfully',
                            ]);
                        }
            }
            public function upgradeartist(Request $request){
                        $upgrade_type = User::where('id',Auth::user()->id)->first();
                        $upgrade_type->typeupgrade_status = '1';
                        $upgrade_type->save();
                        $Artist = Artist_profiles::where('user_id',Auth::user()->id)->first();
                        if($Artist){
                            $Artist->user_id = Auth::user()->id;
                            $Artist->save();
                        }else{
                            $inputs = [ 
                                'user_id' => Auth::user()->id,
                            ];
                            $Artist = Artist_profiles::create($inputs);
                        }
                       
                        return response()->json([
                            'status'    =>200,
                            'success' => true,
                            'message' => 'Type upgraded successfully',
                        ]);
            }

    public function logout(Request $request)
            {   
                if (Auth::check()) {
                    Auth::user()->token()->revoke();
                    return response()->json(['success' =>'logout_success'],200); 
                }else{
                    return response()->json(['error' =>'api.something_went_wrong'], 500);
                }
            }

            public function socialRedirect($service)
            {
                return Socialite::driver($service)->stateless()->redirect();
            }
            public function socialLogin($service,$request)
            {
                $agent = new Agent();
                $browser = $agent->browser();
                $platform = $agent->platform();
                date_default_timezone_set('UTC'); 
                $current_date = Carbon::now(); 
                // new code for apple
                if ($request->isMethod('post')) {
                    if($service == 'apple')
                    { 
                        // dd('coming1');
                        $token = $request->id_token;
                        $user = Socialite::driver('apple')->userFromToken($token);
                    }else{
                        $user = Socialite::driver($service)->stateless()->user();
                        
                    }
                }else{
                    if($service == 'apple')
                    { 
                        // dd('coming3');
                        $token = $request->id_token;
                        $user = Socialite::driver('apple')->userFromToken($token);
            
                    }else{
                        // dd('coming4');
                        $user = Socialite::driver($service)->stateless()->user();
                        
                    }
               
                }
                $socialId = User::where('social_id', $user->id)->first();
            
                $socialEmail = User::where('email', $user->email)->first();
               
                if($socialId)
                {
                //    dd($socialId,1);
                    Auth::login($socialId);
                    $authUser = User::where('email', $socialId->email)->first();
                    $authUser->update(['last_login' => $current_date]);
                  
                    $authToken = $authUser->createToken('MyApp')->accessToken; 
                    if($browser)
                    {
                        return response()->json([
                            'status'    =>200,
                            'success' => true,
                            'message' => 'Login Successfully',
                        ]);
                        
                        // return view('home');
                        // return response($authUser);
                    }
                    else
                    {
                        return response()->json([
                            'status'    =>200,
                            'success' => true,
                            'message' => 'Login Successfully',
                            'access_token' => $authToken,
                            'user_id' => $authUser->id,
                        ]);
                    }
                }
                elseif($socialEmail)
                {
                //    dd($socialEmail,2);
                    Auth::login($socialEmail);
                    $authUser = User::where('email', $socialEmail->email)->first();
                    $authUser->update(['last_login' => $current_date]);
                  
                    $authToken = $authUser->createToken('MyApp')->accessToken; 
                    if($browser)
                    {
                        return response()->json([
                            'status'    =>200,
                            'success' => true,
                            'message' => 'Login Successfully',
                        ]);
                        
                        //return response($authUser);
                    }
                    else
                    {
                        return response()->json([
                            'status'    =>200,
                            'success' => true,
                            'message' => 'Login Successfully',
                            'access_token' => $authToken,
                            'user_id' => $authUser->id,
                        ]);
                    }
                }
                else
                {
                    // dd('3');

                    if(!$user->email)
                    {
                        $user->email =$user->name.'@gmail.com';
                    }
            
                    $createUser = User::updateOrCreate([
                        'name' => $user->name?$user->name:$service,
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
                    {
                        return response()->json([
                            'status'    =>200,
                            'success' => true,
                            'message' => 'Login Successfully',
                        ]);
                        // return view('home');
                    }
                    else
                    {
                        return response()->json([
                            'access_token' => $authToken,
                            'user_id' => $authUser->id,
                            
                        ]);
                    }
                }
            }

            public function getbillinfo(Request $request)
            {
                $user = billinginformation::where('user_id',auth()->user()->id)->first();
                $data = [];
                if($user){
                    $data['id']     = $user->user_id;
                    $data['address']     = $user->address;
                    $data['city']          = $user->city;
                    $data['state']   = $user->state;
                    $data['country']   = $user->country;
                    $data['postalcode']   = $user->postalcode;
                    $response = [
                        'status'    =>200,
                        'success'   => true,
                        'message'   => 'Billing Information Retrived Successfully',
                        'data'      => $data,
                    ];
                    return response()->json($response, 200);   
                } 
                else{ 
                    return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
                } 
            }
            public function storebillinginfo(Request $request)
            {
                $validation = [
                    'address' => 'required',
                    'city' => 'required|regex:/^[A-Za-z\s]+$/',
                    'state' => 'required|regex:/^[A-Za-z\s]+$/',
                    'country' => 'required|regex:/^[A-Za-z\s]+$/',
                    'postalcode' => ['required', 'numeric', 'digits_between:5,6'],
                ];
                $user = billinginformation::where('user_id',Auth::user()->id)->first();
                $validator = $this->validate($request,$validation,
                            [
                                'address.required' => 'Please enter the address',
                                'city.required' => 'Please enter the city',
                                'city.regex' => 'Please enter the string',
                                'state.required' => 'Please enter the state',
                                'state.regex' => 'Please enter the string',
                                'country.required' => 'Please enter the country',
                                'country.regex' => 'Please enter the string',
                                'postalcode.required' => 'Please enter the postalcode',
                                'postalcode.numeric' => 'Please enter the digits',
                                'postalcode.digits_between' => 'please enter the postalcode 5 or 6 digits ',
                            ]);
                if($user){
                    $user->address    = $request['address'];
                    $user->city  = $request['city'];
                    $user->state         = $request['state'];
                    $user->country         = $request['country'];
                    $user->postalcode         = $request['postalcode'];
                    $user->save();
                    return response()->json([
                        'status'    =>200,
                        'success' => true,
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
                            return response()->json([
                                'status'    =>200,
                                'success' => true,
                                'message' => 'Billing information created successfully',
                            ]);
                        }
                }
            }

            public function mobilesociallogin(Request $request){
                
                $validator = Validator::make($request->all(), [
                    'socialtype' => 'required',
                    // 'socialname' => 'required',
                ]);
        
                if($validator->fails()){
                    return response()->json([
                        'message' => 'Invalid params passed',
                          'errors' => $validator->errors()
                      ], 422);       
                }

                
                $agent = new Agent();
                $browser = $agent->browser();
                $platform = $agent->platform();
                date_default_timezone_set('UTC'); 
                $current_date = Carbon::now(); 


                
                $socialid = $request->socialid;
                $socialemail = $request->socialemail;
                $socialname = $request->socialname;
                $social_type = $request->socialtype;
                $social_image = $request->socialimage;
                if($socialid != null){
                    $socialId = User::where('social_id', $socialid)->first();
                }
            
                if($socialemail != null){
                    $socialEmail = User::where('email', $socialemail)->first();
                }
               
                if(isset($socialId))
                {
                    Auth::login($socialId);
                    $authUser = User::where('email', $socialId->email)->first();
                    if($social_image != null){

                        $authUser->update(['last_login' => $current_date, 'image' => $social_image]);
                    }else{

                        $authUser->update(['last_login' => $current_date]);
                    }
                  
                    $authToken = $authUser->createToken('MyApp')->accessToken; 
                    if($browser)
                    {
                        return response()->json([
                            'status'    =>200,
                            'success' => true,
                            'message' => 'Login Successfully',
                        ]);
                    }
                    else
                    {
                        return response()->json([
                            'status'    =>200,
                            'success' => true,
                            'message' => 'Login Successfully',
                            'access_token' => $authToken,
                            'user_id' => $authUser->id,
                            'user_email' => $authUser->email,
                        ]);
                    }
                }
                elseif(isset($socialEmail))
                {
                    Auth::login($socialEmail);
                    $authUser = User::where('email', $socialEmail->email)->first();
                    if($social_image != null){

                        $authUser->update(['last_login' => $current_date, 'image' => $social_image]);
                    }else{

                        $authUser->update(['last_login' => $current_date]);
                    }
                  
                    $authToken = $authUser->createToken('MyApp')->accessToken; 
                    if($browser)
                    {
                        return response()->json([
                            'status'    =>200,
                            'success' => true,
                            'message' => 'Login Successfully',
                        ]);
                    }
                    else
                    {
                        return response()->json([
                            'status'    =>200,
                            'success' => true,
                            'message' => 'Login Successfully',
                            'access_token' => $authToken,
                            'user_id' => $authUser->id,
                            'user_email' => $authUser->email,
                        ]);
                    }
                }
                else
                {

                    if(!$socialemail)
                    {

                        $socialemail =$socialname.'@gmail.com';
                    }
            
                    $createUser = User::updateOrCreate([
                        'name' => $socialname?$socialname:$social_type,
                        'email' => $socialemail,
                        'social_id' => $socialid,
                        'social_type' => $social_type,
                        'image' => ($social_image != null) ? $social_image : null,
                        'password' => encrypt('john123'),
                        'last_login' =>  $current_date
                    ]);
                    Auth::login($createUser);
                    $authUser = User::where('email', $socialemail)->first();
                    $authToken = $authUser->createToken('MyApp')->accessToken; 
                    if($browser)
                    {
                        return response()->json([
                            'status'    =>200,
                            'success' => true,
                            'message' => 'Login Successfully',
                        ]);
                    }
                    else
                    {
                        return response()->json([
                            'access_token' => $authToken,
                            'user_id' => $authUser->id,
                            'user_email' => $authUser->email,
                            
                        ]);
                    }
                }
            }

            public function deleteaccount($id){
                $usertype = User::where('id',$id)->first();
                if($usertype){

                    $usertype->delete();
                    return response()->json([
                        'status'  => 200,
                        'success' => true,
                        'message' => 'Account Deleted Successfully',
                        'data' => []
                    ]);
                }
                else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Account Not Found', // the ,message you want to show
                        
                    ], 422);
                }
            }
}
