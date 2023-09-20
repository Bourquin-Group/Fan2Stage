<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActionFile;
use Image;
class ActionController extends Controller
{
    public function action(Request $request)
    {
    	$action = ActionFile::all();
    	return view('admin.actionlist', compact('action'));
    }
     public function actioncreation(Request $request)
    {
    	return view('admin.action_manage');
    }
     public function actionstore(Request $request)
    {
        $validatedData = $request->validate([
            'action_name' => 'required',
            'action_desc' => 'required',
            'action_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ], [
            'action_name.required' => 'Action Name Is Required',
            'action_desc.required' => 'Action Description Is Required',
        ]);



        $actionfile = $request->file('action_file');
     $actionfilename = time().'.'.$actionfile->getClientOriginalExtension();
   if (!file_exists(public_path('assets/admin/action/')))
     mkdir(public_path('assets/admin/action/'), 0777, true);

     $destinationPath_2 = public_path('assets/admin/action/');
     $actionfile->move($destinationPath_2, $actionfilename);
        $details              = [
            "action_name"    => $request->action_name,
            "action_desc"    => $request->action_desc,
            "action_file"     => $actionfilename,
            "action_status"     => 1,
            "created_by"    => auth()->user()->id,
            "updated_by"    =>null,
        ];
         $supplier_array        = ActionFile::create($details);
        return redirect('/admin/action')->with('Success', 'Action File Added Successfully.');
    }

        public function editaction($id)
    {
      
        $id             = base64_decode($id);
        $editaction   = ActionFile::where('id',$id)->first();
        if(!$editaction)
        {
            return redirect('/admin/action')->with('Error','Action File is not available');
        }
        return view('admin.action_edit', compact('editaction'));
    }
    public function updateaction(Request $request, $id)
    {
    	//$id             = base64_decode($id);
    	 $editaction   = ActionFile::where('id',$id)->first();


    
         $actionfile = $request->file('action_file');
         if($actionfile != null){
            $actionfilename = time().'.'.$actionfile->getClientOriginalExtension();
            if (!file_exists(public_path('assets/admin/action/')))
              mkdir(public_path('assets/admin/action/'), 0777, true);
         
              $destinationPath_2 = public_path('assets/admin/action/');
              $actionfile->move($destinationPath_2, $actionfilename);
         }
        

        $details              = [
            "action_name"    => $request->action_name,
            "action_desc"    => $request->action_desc,
            "action_file"     => isset($actionfilename)?$actionfilename:$editaction->action_file,
            "action_status"         => isset($request->action_status) ? 1 : 0,
            "updated_by"    => auth()->user()->id,
          
        ];
        $introductoryUpdate  = ActionFile::where('id',$id)->update($details);
        if(!$introductoryUpdate)
        {
            return redirect('/admin/action')->with('Error','Action not updated');
        }
        return redirect('/admin/action')->with('Success','Action Files Updated Sucessfully');
    }
    public function deleteaction($id)
    {
        $id             = base64_decode($id);
        $deleteaction = ActionFile::where([['id', $id]])->delete();
       
        if(!$deleteaction)
        {
            return redirect('/admin/action')->with('Error', 'Action not deleted');
        }
        return redirect('/admin/action')->with('Success', 'Action Deleted Successfully');

        }
}
