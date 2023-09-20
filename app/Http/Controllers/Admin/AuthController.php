<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Session;
use Auth;
class AuthController extends Controller
{

    public function loginForm(Request $request)
    {
        //dd('coming');
        return view('admin.admin-login');
    }
    public function login(Request $request)
    {
       // dd('bb');
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]) || Auth::attempt(['phone_number' => $request->email, 'password' => $request->password]) )
        { 
            $user = Auth::user(); 
            if(Auth::user()->user_type == "admin")
            {
                //dd('cc');
             //dd(Auth::user()->user_type);
                return redirect()->route('admin.admin-home');
            }
            else
            {
                
                //$this->guard()->logout();
                Auth::logout();
                $request->session()->invalidate();
                // if($_POST['type'] == 'admin')
                //     return redirect('/admin');
                // else
                //     return redirect()->route('login');
                
            } 
        }
        else
        {
            throw ValidationException::withMessages([
               $request->email => [trans('auth.failed')],
            ]);
            
        }
     }

     public function logout(Request $request)
     {
         //dd('coming');exit();
         // dd($request);exit();
         $usertype = Auth::user()->user_type;
         // echo $usertype;exit;
         Auth::logout();
 
         $request->session()->invalidate();
         
         if($usertype =="admin")
             return redirect('/admin');
         else
             return redirect('/login');
     }


    //   public function authenticate()
    // {
    //     if (Auth::attempt(['email' => $email, 'password' => $password]))
    //     {
    //         return redirect()->intended('dashboard');
    //     }
    //     else {
    //     // Go back on error (or do what you want)
    //     return redirect()->back('wrong');
    // }
    // }
}
