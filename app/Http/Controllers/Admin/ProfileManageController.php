<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileManagementRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use App\Models\country;
use Session;
use Hash;
use Image;
use Auth;
class ProfileManageController extends Controller
{
     public function editprofile($id)
    {
    	//dd('hi');
      
        //$id             = base64_decode($id);
        $editprofile   = User::where('id',$id)->first();
       // $countryselect =  User::where('id',$id)->first();
        $country   = country::all();
        if(!$editprofile)
        {
            return redirect('/admin/dashboard')->with('Error','User id is not available');
        }
       
        return view('admin.profile_edit', compact('editprofile','country'));
    }

     public function updateprofile(ProfileManagementRequest $request, $id)
    {
	 $editprofile   = User::where('id',$id)->first();
	if($request->hasFile('image')){
	$image = $request->file('image');
        
     $imgfilename = time().'.'.$image->getClientOriginalExtension();
   if (!file_exists(public_path('assets/images/profile/')))
     mkdir(public_path('assets/images/profile/'), 0777, true);
     if (!file_exists(public_path('assets/images/profile/thumbnail/')))
     mkdir(public_path('assets/images/profile/thumbnail/'), 0777, true);
     //thumbnail
       $destinationPath = public_path('assets/images/profile/thumbnail');
     $img = Image::make($image->getRealPath());     
     $img->resize(100, 100);
     $img->save($destinationPath.'/'.$imgfilename);  

     $destinationPath_2 = public_path('assets/images/profile/');
     $image->move($destinationPath_2, $imgfilename);
 }

        $details              = [
            "name"    => $request->name,
            "country_code"    => $request->ccode,
            "phone_number"     => $request->phone,
            "email"         => $request->email,
            //"password"         =>Hash::make($request->password),
            "user_type"     =>'admin',
            "status"        =>1,
          
        ];
         $details['image'] =  isset($imgfilename)?$imgfilename:$editprofile->image;
//dd(  $details );
        $profileUpdate  = User::where('id',$id)->update($details);
        if(!$profileUpdate)
        {
            return redirect('/admin/dashboard')->with('Error','Profile not updated');
        }
        return redirect('/admin/dashboard')->with('Success','Profile Details Updated Sucessfully');
    }


     public function editpassword($id)
    {
    	//dd('hi');
      
        //$id             = base64_decode($id);
        $editpassword   = User::where('id',$id)->first();
       // $countryselect =  User::where('id',$id)->first();
        $country   = country::all();
        if(!$editpassword)
        {
            return redirect('/admin/dashboard')->with('Error','User id is not available');
        }
       
        return view('admin.password_edit', compact('editpassword','country'));
    }

     public function updatepassword(ChangePasswordRequest $request, $id)
    {
	 $user   = User::where('id',$id)->first();
    	if (Hash::check($request->password, $user->password)) {
	if(Hash::check($request->password, auth()->user()->password)){

		$details              = [
            "password"    => Hash::make($request->newpassword),
            // "country_code"    => $request->ccode,
            // "phone_number"     => $request->phone,
            // "email"         => $request->email,
            // "password"         =>Hash::make($request->password),
            // "user_type"     =>'admin',
             "status"        =>1,
          
        ];
        $passwordUpdate  = User::where('id',$id)->update($details);

	}

         $request->session()->flash('success', 'Password changed');
        // route('logout')
         Auth::logout();
   return redirect('/admin/dashboard')->with('Success','Password Updated Sucessfully');

} else {
    $request->session()->flash('error', 'Password does not match');
    return redirect('/admin/passwordedit/1')->with('Error','Old Password Not Matched');
    
}  
       
//dd(  $details );
        
        // if(!$passwordUpdate)
        // {
        //     return redirect('/admin/dashboard')->with('Error','Profile not updated');
        // }
        // return redirect('/admin/dashboard')->with('Success','Password Updated Sucessfully');
    }
}
