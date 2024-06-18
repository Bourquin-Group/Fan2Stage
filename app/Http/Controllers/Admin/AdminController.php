<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Image;
use Hash;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function admin(Request $request)
    {
    	  $admin = User::where('user_type','admin')->get();
    	return view('admin.adminlist', compact('admin'));
    }
     public function admincreation(Request $request)
    {
    	return view('admin.admin_manage');
    }
     public function adminstore(Request $request)
    {
        $image = $request->file('image');
   if (!file_exists(public_path('assets/images/admin/thumbnail/')))
     mkdir(public_path('assets/images/admin/thumbnail/'), 0777, true); 
    $file = $request->file('image');
    $fileName = $file->getClientOriginalName();
    $destinationPath = public_path('assets/images/admin/thumbnail/');
    $image->move($destinationPath, $fileName);
        $details              = [
            "name"    => $request->name,
            "email"    => $request->email,
            "password"    =>Hash::make($request->password),
            "user_type"    => "admin",
            "status"     => 0,
        ];

        $details['image'] =  $fileName;


         $supplier_array        = User::create($details);
        return redirect('/admin/admin')->with('Success', 'Admin Added Successfully.');
    }

        public function editadmin($id)
    {
      
        $id             = base64_decode($id);
        $editadmin   = User::where('id',$id)->first();
        if(!$editadmin)
        {
            return redirect('/admin/admin')->with('Error','Admin user is not available');
        }
       
        return view('admin.admin_edit', compact('editadmin'));
    }
    public function updateadmin(Request $request, $id)
    {
    	 $editadmin   = User::where('id',$id)->first();
if($request->hasFile('image')){
    $file = $request->file('image');

    if ($file) {
        $imgfilename = $file->getClientOriginalName();
        $destinationPath = public_path('assets/images/admin/thumbnail/');
        $file->move($destinationPath, $imgfilename);
        $old_path = public_path('/assets/images/admin/thumbnail/' . $editadmin->image);
        if (File::exists($old_path) && $editadmin->image) {
            unlink($old_path);
        }
    } else {
        $imgfilename = $editadmin->image;
    }
 }
        $details              = [
           "name"    => $request->name,
            "email"    => $request->email,
            "status"    => ($request->has('status') == true) ? '1' : '0',
        ];
        $details['image'] =  isset($imgfilename)?$imgfilename:$editadmin->image;
        $adminUpdate  = User::where('id',$id)->update($details);
        $editadmin->save();
        if(!$adminUpdate)
        {
            return redirect('/admin/admin')->with('Error','Admin not updated');
        }
        return redirect('/admin/admin')->with('Success','Admin Updated Sucessfully');
    }
    public function deleteadmin($id)
    {
        $id             = base64_decode($id);
        $deleteadmin = User::where([['id', $id]])->delete();
       
        if(!$deleteadmin)
        {
            return redirect('/admin/admin')->with('Error', 'Admin not deleted');
        }
        return redirect('/admin/admin')->with('Success', 'Admin Deleted Successfully');

        }
}
