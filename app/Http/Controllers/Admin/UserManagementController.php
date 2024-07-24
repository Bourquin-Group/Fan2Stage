<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagementRequest;
use App\Models\User;
use App\Models\country;
use App\Models\Artist_profiles;
use Session;
use Hash;
use Mail;
class UserManagementController extends Controller
{
    public function user(Request $request)
    {
    	  $user = User::where('user_type','users')->get();
    	 //printf($data)
    	return view('admin.userlist', compact('user'));
    }
     public function usercreation(Request $request)
    {
        $country   = country::all();
    	return view('admin.user',compact('country'));
    }
     public function userstore(UserManagementRequest $request)
    {
        $details              = [
            "name"    => $request->name,
            "country_code"    => $request->ccode,
            "phone_number"     => $request->phone,
            "email"         => $request->email,
            "password"         => bcrypt($request->password),
            "user_type"     =>'users',
            "status"        =>1,
            "timezone"        => 'IST',
        ];
         $supplier_array        = User::create($details);
         $email = $supplier_array->email;
         $data = array(
                        'name' => $request->name,
                    );
         Mail::send('mail.register',$data,function($message) use($email){
            $message->to($email);
            $message->subject('Congratulations');
            });
        return redirect('/admin/user')->with('Success', 'User created successfully.');
    }
    public function edituser($id)
    {
      
        $id             = base64_decode($id);
        $edituser   = User::where('id',$id)->first();
       // $countryselect =  User::where('id',$id)->first();
        $country   = country::all();
        if(!$edituser)
        {
            return redirect('/admin/user')->with('Error','User id is not available');
        }
       
        return view('admin.user_edit', compact('edituser','country'));
    }
    public function updateuser(UserManagementRequest $request, $id)
    {
        $details              = [
            "name"    => $request->name,
            "country_code"    => $request->ccode,
            "phone_number"     => $request->phone,
            "email"         => $request->email,
            "password"         =>Hash::make($request->password),
            "user_type"     =>'users',
            "status"        =>1,
          
        ];
//dd(  $details );
        $userUpdate  = User::where('id',$id)->update($details);
        if(!$userUpdate)
        {
            return redirect('/admin/user')->with('Error','User not updated');
        }
        return redirect('/admin/user')->with('Success','User Details Updated Sucessfully');
    }
    public function deleteuser($id)
    {
        $id             = base64_decode($id);
        $deleteUser = User::where([['id', $id]])->delete();
       
        if(!$deleteUser)
        {
            return redirect('/admin/user')->with('Error', 'User not deleted');
        }
        return redirect('/admin/user')->with('Success', 'User deleted successfully');

        }

        //Artist

    public function artist(Request $request)
    {

         $user = User::where('user_type','artists')->get();
         //printf($data)
        return view('admin.artistlist', compact('user'));
    }
     public function artistcreation(Request $request)
    {
        return view('admin.artist');
    }
     public function artiststore(Request $request)
    {
        $details              = [
            "name"    => $request->name,
            "phone_number"     => $request->phone,
            "stage_name"     => $request->stage,
            "email"         => $request->email,
            "password"         => Hash::make($request->password),
            "user_type"     =>'artists',
            "status"        =>1,
            // "status"         => ($request->has('status') == true) ? 1 : 0,
        ];
         $supplier_array        = User::create($details);
         $artistid              = [
            "user_id"    => $supplier_array->id,
         ];
         $artist_profile = Artist_profiles::create($artistid);
        return redirect('/admin/artist')->with('Success', 'Artist created successfully.');
    }
    public function editartist($id)
    {
      
        $id             = base64_decode($id);
        $edituser   = User::where('id',$id)->first();
        
        if(!$edituser)
        {
            return redirect('/admin/artist')->with('Error','Artist id is not available');
        }
       
        return view('admin.artist_edit', compact('edituser'));
    }
    public function viewartist($id)
    {
      
        $id             = base64_decode($id);
        $edituser   = User::with('artistProfile')->where('id',$id)->first();
        
        if(!$edituser)
        {
            return redirect('/admin/artist')->with('Error','Artist id is not available');
        }
       
        return view('admin.artist_view', compact('edituser'));
    }
    public function updateartist(Request $request, $id)
    {
        $details              = [
            "name"    => $request->name,
            "phone_number"     => $request->phone,
            "email"         => $request->email,
            "password"         =>Hash::make($request->password),
            "user_type"     =>'artists',
            "status"        =>1,
          
        ];
//dd(  $details );
        $userUpdate  = User::where('id',$id)->update($details);
        if(!$userUpdate)
        {
            return redirect('/admin/artist')->with('Error','Artist not updated');
        }
        return redirect('/admin/artist')->with('Success','Artist Details Updated Sucessfully');
    }
    public function deleteartist($id)
    {
        $id             = base64_decode($id);
        $deleteUser = User::where([['id', $id]])->delete();
       
        if(!$deleteUser)
        {
            return redirect('/admin/artist')->with('Error', 'Artist not deleted');
        }
        return redirect('/admin/artist')->with('Success', 'Artist deleted successfully');

        }


}
