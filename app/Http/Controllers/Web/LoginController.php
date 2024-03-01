<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\timezone_change;
use App\Models\timezone_notify;
use Auth;
use Session;
use Redirect;
use App\Models\Admin\cms_manage;
use Mail;
class LoginController extends Controller
{
  use AuthenticatesUsers;
     public function login(){
        return view('artistweb.login');
    }

  public function loginstore(Request $request){
    $login = app('App\Http\Controllers\API\AuthController')->login($request);
        $login_dataArray = json_decode ($login->content(), true);
        //dd($login_dataArray);
       if($login_dataArray['success'] == 'true'){
        $login = $login_dataArray['data'];
        Session::put('user_timezone', $login['timezone']);

        // Check if multiple logins are allowed
        if ($login_dataArray['message'] == 'You are already logged in.') {
          // Log out the user if already logged in on another device
          if (auth()->check() && auth()->user()->session_id !== session()->getId()) {
              auth()->logout();
              Session::flash('error', 'You are already logged in.');
              return redirect('/fan/login');
          }
      }

        $timezone_date = timezone_change::where('user_id',Auth::user()->id)->first();
        $timezone_getdate = timezone_notify::where('id',1)->first();
        
        if(isset($timezone_date['status'])){
        if($timezone_date['status'] == 0){ //no
          if($timezone_getdate['date'] == date('Y-m-d') && $timezone_date['modify_date'] == date('Y-m-d')){
            Session::put('timezonechange', "no");
          }else{
            if($timezone_date['modify_date'] == date('Y-m-d')){
              Session::put('timezonechange', "no");

            }else{
              Session::put('timezonechange', "yes");
            }
          }
        }else{
          if($timezone_getdate['date'] == date('Y-m-d') && $timezone_date['modify_date'] == date('Y-m-d')){ //yes
            Session::put('timezonechange', "no");
          }else{
            if($timezone_date['modify_date'] == date('Y-m-d')){
              Session::put('timezonechange', "no");

            }else{
              Session::put('timezonechange', "yes");
            }
          }
        }
      }else{
        Session::put('timezonechange', "no");
      }
        
        return redirect('/web/artisthome');
       }else{
        if($login_dataArray['message'] == 'You are already logged in.'){
          Session::flash('error', $login_dataArray['message']);
        }
        if($login_dataArray['message'] =='notverified')
        {
        Session::flash('error', "You are not verified user");
        }
        else{
          if($login_dataArray['message'] =='Invalid User'){
            Session::flash('error', "Incorrect Email Or Password");
          }else{
            $email = $request->email;
            return Redirect::back()->withInput(['email' => $email]);
            // return Redirect::back()->withInput();
          }

         
       }
       return redirect('/web/login');
        //return view('artistweb.login',compact('login'));
       }
     }

    public function register(){
       $content = cms_manage::where('slug','terms-and-condition')->first();
        return view('artistweb.register',compact('content'));
    }

    public function registerstore(Request $request){
      $request->user_type ="artists";
    $register = app('App\Http\Controllers\API\AuthController')->register($request);
        $register_dataArray = json_decode ($register->content(), true);
        //dd($register_dataArray);

        //dd(old());
        if(isset($register_dataArray['errors'])){
        $errors1= $register_dataArray['errors'];
        }
       if(isset($register_dataArray['success']) == 'true'){
        $register = $register_dataArray['data'];
        $uuid= $register['uuid'];
        $type ="register";
        return redirect('/web/otp/'.$uuid.'/'.$type);
       }else{
        $login = [];
       //return redirect('/web/register')->with('Error', 'Unauthorized.');
       // return back()->with(['errors1' => $errors1]);
        // redirect()->back()->withInput(Input::all()->withMessage('some validation error message'));
        //return redirect()->back()->withInput(Input::all());
        return Redirect::back()->withInput();
    //     return back()
    // ->withInput()
    // ->withErrors(['name.required', 'Name is required']);
        //return view('artistweb.register',compact('errors1'));
       }
     }

     public function otp(Request $request){
      $type = $request->type;
      //dd( $request);
    //$resend = "The OTP has been sent for your mail";
      $user  = User::where('uuid',$request->uuid)->first();
      //dd($user);
        return view('artistweb.otpverification',compact('user','type'));
    }

       public function otpverification(Request $request){
        //dd($request);
        $request->otp=implode('',json_decode(json_encode($request->otp)));
        $type =  $request->type;
        $uuid = $request->uuid;
        //dd($uuid);
    $otp = app('App\Http\Controllers\API\AuthController')->verifyOtp($request);
        $otp_dataArray = json_decode ($otp->content(), true);
        // dd($otp_dataArray);
        //dd($otp_dataArray['data']);
        // $user = $otp_dataArray['email'];
         $msg= $otp_dataArray['message'];
        if(isset($otp_dataArray['message'])){
        $errors1= $otp_dataArray['message'];
        //dd( $errors1);
        }
        if(isset($otp_dataArray['message'])){
        $errors1= $otp_dataArray['message'];
        //dd( $errors1);
        }
        // $otp = $otp_dataArray['data'];
       if(isset($otp_dataArray['success']) == 'true'){
        if($otp_dataArray['success'] == true){
          $user = User::where('uuid',$uuid)->first();
          $data = array(
            'name' => $user->name,
        );
        $email = $user->email;
          Mail::send('mail.register',$data,function($message) use($email){
            $message->to($email);
            $message->subject('Congratulations');
            });
        }
        if($type=='register'){
          Session::flash('message', "You have Registered Successfully");
          return redirect('/web/login');
        }
        else{
          //dd($uuid);
          return redirect('/web/changepassword/'.$uuid);
        }
        
       }else{
        //$errors1 = [];
        //dd($errors11);
        //return Redirect::back();
        $status =  $msg;
        return back()->with(['status' => $status]);
         //return redirect()->back()->with('Error','Invalid');   
       //return redirect('/web/otp')->with('Error', 'Unauthorized.');
       //return view('artistweb.otpverification',compact('errors1'));
       }
     }

       public function forgotpassword(Request $request){
      
        return view('artistweb.forgotpassword');
      }

      public function forgotpasswordcheck(Request $request){
        //return $request;
        
        $forgotpassword = app('App\Http\Controllers\API\AuthController')->forgotpassword($request);
        $forgotpassword_dataArray = json_decode ($forgotpassword->content(), true);
        $msg= $forgotpassword_dataArray['message'];
        // if($msg){
        //   $status =  $msg;
        //   return back()->with(['status' => $status]);
        // }
        // if(isset($forgotpassword_dataArray['message'])){
        //   $errors1= $forgotpassword_dataArray['message'];
        //   dd($errors1);
        // }
        //dd($forgotpassword_dataArray);
       if(isset($forgotpassword_dataArray['success']) == 'true'){
        $forgotpassword = $forgotpassword_dataArray['data'];
        $uuid= $forgotpassword['uuid'];
        $type ="forgot";
         return redirect('/web/otp/'.$uuid.'/'.$type); 
       }else{
        //$login = [];
      //  $status =  $msg;

       return Redirect::back()->withInput();
       //return redirect('/web/login')->with('Error', 'Unauthorized.');
        //return view('artistweb.login',compact('login'));
       }
     }

  public function resendotp(Request $request){
      
         $forgotpassword = app('App\Http\Controllers\API\AuthController')->resendotp($request);
         
         
         return $forgotpassword;

       
      }
      public function changepassword(Request $request){
         $user  = User::where('uuid',$request->uuid)->first();
        return view('artistweb.changepassword',compact('user'));
      }

      public function changepasswordstore(Request $request){
        $changepassword = app('App\Http\Controllers\API\AuthController')->resetPassword($request);
        $changepassword_dataArray = json_decode ($changepassword->content(), true);
        if(isset($changepassword_dataArray['success']) && $changepassword_dataArray['success']  == 'true')
        {
          $changepassword = $changepassword_dataArray['data'];
            Session::flash('success', "Password Changed Successfully");
            return redirect('/web/login');
        }
        else
        {
          if(isset($changepassword_dataArray['flag']) == 1){
            Session::flash('message', $changepassword_dataArray['message']);
            return back();
          }else{
            return Redirect::back()->withInput();
          }
        }
     }
     public function logout(Request $request)
     {
      $user = Auth::user();
        $user->session_id = null;
        $user->save();
         Auth::logout();
        return redirect('/web/login');
     }
     public function alllogoutwebs(Request $request)
     {
      $user = User::where('email',$request->email)->first();
        $user->session_id = null;
        $user->save();
         return response()->json([
          'success' => true,
          'message' => 'Session cleared successfully',
      ]);
     }

}
