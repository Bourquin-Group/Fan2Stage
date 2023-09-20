<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\cms_manage;
use Image;
use Auth;
class CmsManageController extends Controller
{
     public function cms(Request $request)
    {
    	  $cms = cms_manage::all();
    	 //printf($data)
    	return view('admin.cmslist', compact('cms'));
    }
    //  public function cmscreation(Request $request)
    // {
    //     //$country   = country::all();
    // 	return view('Admin.cms_manage');
    // }
    //  public function cmsstore(Request $request)
    // {
    //     //dd($request);
    //     $details              = [
    //         "title"    => $request->title,
    //         "slug"    => $request->slug,
    //         "description"     => $request->description,
    //         // "email"         => $request->email,
    //         // "password"         => Hash::make($request->password),
    //         // "user_type"     =>'users',
    //         // "status"        =>1,
    //         // "status"         => ($request->has('status') == true) ? 1 : 0,
    //     ];
    //      $supplier_array        = cms_manage::create($details);
    //     return redirect('/admin/cms')->with('Success', 'CMS Content Added Successfully.');
    // }

        public function editcms($id)
    {
      
        $id             = base64_decode($id);
        $editcms   = cms_manage::where('id',$id)->first();
       // $countryselect =  User::where('id',$id)->first();
        //$country   = country::all();
        if(!$editcms)
        {
            return redirect('/admin/cms')->with('Error','CMS id is not available');
        }
       
        return view('admin.cms_edit', compact('editcms'));
    }
    public function updatecms(Request $request, $id)
    {
        // dd($request->cms_status);
        $editcms   = cms_manage::where('id',$id)->first();
    if($request->hasFile('image')){
    $image = $request->file('image');
        
     $imgfilename = time().'.'.$image->getClientOriginalExtension();
   if (!file_exists(public_path('assets/images/cms/')))
     mkdir(public_path('assets/images/cms/'), 0777, true);
     if (!file_exists(public_path('assets/images/cms/thumbnail/')))
     mkdir(public_path('assets/images/cms/thumbnail/'), 0777, true);
     //thumbnail
       $destinationPath = public_path('assets/images/cms/thumbnail');
     $img = Image::make($image->getRealPath());     
     $img->resize(100, 100);
     $img->save($destinationPath.'/'.$imgfilename);  

     $destinationPath_2 = public_path('assets/images/cms/');
     $image->move($destinationPath_2, $imgfilename);
 }

        $details              = [
           "title"    => $request->title,
            "slug"    => $request->slug,
            "description"     => $request->description,
            "status"         => ($request->cms_status == "1") ? 1 : 0,
          
        ];
        $details['image'] =  isset($imgfilename)?$imgfilename:$editcms->image;
        $cmsUpdate  = cms_manage::where('id',$id)->update($details);
        if(!$cmsUpdate)
        {
            return redirect('/admin/cms')->with('Error','CMS not updated');
        }
        return redirect('/admin/cms')->with('Success','CMS Content Updated Sucessfully');
    }
    // public function deletecms($id)
    // {
    //     $id             = base64_decode($id);
    //     $deleteCms = cms_manage::where([['id', $id]])->delete();
       
    //     if(!$deleteCms)
    //     {
    //         return redirect('/admin/cms')->with('Error', 'User not deleted');
    //     }
    //     return redirect('/admin/cms')->with('Success', 'CMS Content Deleted Successfully');

    //     }
}
