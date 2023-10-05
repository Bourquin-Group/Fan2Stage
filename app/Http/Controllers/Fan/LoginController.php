<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\timezone_change;
use App\Models\timezone_notify;
use Auth;
use Session;
use Redirect;
use App\Models\Admin\cms_manage;
class LoginController extends Controller
{
    public function login(){
        return view('fanweb.login');
    }

    public function loginstore(Request $request){
      $login = app('App\Http\Controllers\API\AuthController')->login($request);
      $login_dataArray = json_decode ($login->content(), true);
      if($login_dataArray['success'] == 'true'){
        $login = $login_dataArray['data'];
        Session::put('user_timezone', $login['timezone']);

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
        
        return redirect('/fan/fanhome');
      }else{
        if($login_dataArray['message'] == 'Your Email Is Not Existing'){
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
            return Redirect::back()->withInput();
          }
        }
        return redirect('/fan/login');
      }
    }

    public function register(){
      $content = cms_manage::where('slug','terms-and-condition')->first();
      return view('fanweb.register',compact('content'));
    }

    public function registerstore(Request $request){
          $request->user_type ="users";
          $register = app('App\Http\Controllers\API\AuthController')->register($request);
          $register_dataArray = json_decode ($register->content(), true);
          if(isset($register_dataArray['errors'])){
            $errors1= $register_dataArray['errors'];
          }
        if(isset($register_dataArray['success']) == 'true'){
            Session::flash('success', "You have Registered Successfully");
            return redirect('fan/login');
        }else{
            $login = [];
            return Redirect::back()->withInput();
        }
 
    }

    public function otp(Request $request){
      $type = $request->type;
      $user  = User::where('uuid',$request->uuid)->first();
        return view('fanweb.verification',compact('user','type'));
    }

    public function otpverification(Request $request){
        //dd($request);
        $request->otp=implode('',json_decode(json_encode($request->otp)));
        $type =  $request->type;
        $uuid = $request->uuid;
        //dd($uuid);
    $otp = app('App\Http\Controllers\API\AuthController')->verifyOtp($request);
        $otp_dataArray = json_decode ($otp->content(), true);
        //dd($otp_dataArray['message']);
        //dd($otp_dataArray['data']);
        // $user = $otp_dataArray['email'];
         $msg= $otp_dataArray['message'];
        if(isset($otp_dataArray['message'])){
        $errors1= $otp_dataArray['message'];
        //dd( $errors1);
        }
       if(isset($otp_dataArray['success']) == 'true'){
        $otp = $otp_dataArray['data'];
        if($type=='forgot'){
          return redirect('/fan/changepassword/'.$uuid);
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
      return view('fanweb.forgot-password');
       
    }

    public function forgotpasswordcheck(Request $request){
      
      $forgotpassword = app('App\Http\Controllers\API\AuthController')->forgotpassword($request);
      $forgotpassword_dataArray = json_decode ($forgotpassword->content(), true);
        if(isset($forgotpassword_dataArray['message']))
        {
          $errors1= $forgotpassword_dataArray['message'];
        }
        if(isset($forgotpassword_dataArray['success']) == 'true')
        {
          $forgotpassword = $forgotpassword_dataArray['data'];
          $forgotpassword = $forgotpassword_dataArray['data'];
          $uuid= $forgotpassword['uuid'];
          $type ="forgot";
           return redirect('/fan/otp/'.$uuid.'/'.$type);
        }else
        {
            return Redirect::back()->withInput();
        }
    }
    public function resendotp(Request $request){
      $forgotpassword = app('App\Http\Controllers\API\AuthController')->forgotpassword($request);
      return $forgotpassword;
   }

    public function changepassword(Request $request)
    {
      $user  = User::where('uuid',$request->uuid)->first();
      return view('fanweb.create-password',compact('user'));
    }

    public function changepasswordstore(Request $request){
      $changepassword = app('App\Http\Controllers\API\AuthController')->resetPassword($request);
      $changepassword_dataArray = json_decode ($changepassword->content(), true);
      
        if(isset($changepassword_dataArray['success']) && $changepassword_dataArray['success']  == 'true')
        {
          $changepassword = $changepassword_dataArray['data'];
            Session::flash('success', "Password Changed Successfully");
            return redirect('/fan/login');
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

         Auth::logout();
        return redirect('/fan/login');
     }

  public function dashboard()
  {
    return view('fanweb.dashboard');
  }   
}
