<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SettingRequest;
use App\Models\setting;
class SettingController extends Controller
{
    public function setting(SettingRequest $request)
    {
    	  $setting = setting::all();
    	 //printf($data)
    	return view('admin.settinglist', compact('setting'));
    }
     public function settingcreation(SettingRequest $request)
    {
        //$country   = country::all();
    	return view('admin.setting_manage');
    }
     public function settingstore(SettingRequest $request)
    {
        //dd($request);
        $details              = [
            "name"    => $request->title,
            "key"    => $request->slug,
            "value"     => $request->description,
            "category"     => $request->category,
            // "email"         => $request->email,
            // "password"         => Hash::make($request->password),
            // "user_type"     =>'users',
            // "status"        =>1,
            // "status"         => ($request->has('status') == true) ? 1 : 0,
        ];
         $supplier_array        = setting::create($details);
        return redirect('/admin/setting')->with('Success', 'Setting Added Successfully.');
    }

        public function editsetting($id)
    {
      
        $id             = base64_decode($id);
        $editsetting   = setting::where('id',$id)->first();
       // $countryselect =  User::where('id',$id)->first();
        //$country   = country::all();
        if(!$editsetting)
        {
            return redirect('/admin/setting')->with('Error','Setting id is not available');
        }
       
        return view('admin.setting_edit', compact('editsetting'));
    }
    public function updatesetting(SettingRequest $request, $id)
    {
    	//dd($request);
        $details              = [
           "name"    => $request->title,
            "key"    => $request->slug,
            "value"     => $request->description,
            "category"     => $request->category,
            "status"         => ($request->has('status') == true) ? 1 : 0,
          
        ];
//dd(  $details );
        $settingUpdate  = setting::where('id',$id)->update($details);
        if(!$settingUpdate)
        {
            return redirect('/admin/setting')->with('Error','Setting not updated');
        }
        return redirect('/admin/setting')->with('Success','Setting Content Updated Sucessfully');
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
