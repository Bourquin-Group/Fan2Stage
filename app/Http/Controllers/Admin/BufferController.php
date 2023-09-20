<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\basic_setting;
use Image;
use Auth;

class BufferController extends Controller
{
    public function buffer(Request $request)
    {
    	$buffer = basic_setting::all();
    	return view('admin.bufferlist', compact('buffer'));
    }
     public function buffercreation(Request $request)
    {
    	return view('admin.buffer_manage');
    }
     public function bufferstore(Request $request)
    {
        $validatedData = $request->validate([
            'funname' => 'required',
            'funcode' => 'required',
            'fundesc' => 'required',
            'funval1' => 'required|numeric',
        ], [
            'funname.required' => 'funname is required',
            'funcode.required' => 'funcode is required',
            'fundesc.required' => 'fundesc is required',
            'funval1.required' => 'value is required',
            'funval1.numeric' => 'value must be numeric.',
        ]);
        $user = Auth::user();
        $details              = [
            "funname"    => $request->funname,
            "funcode"    => $request->funcode,
            "fundesc"    => $request->fundesc,
            "funval1"    => $request->funval1,
            "created_by"    => $user->id,
            "funstatus"     => 1,
        ];
         $supplier_array        = basic_setting::create($details);
        return redirect('/admin/buffer')->with('Success', 'Functionality Added Successfully.');
    }

        public function editbuffer($id)
    {
      
        $id             = base64_decode($id);
        $editbuffer   = basic_setting::where('id',$id)->first();
        if(!$editbuffer)
        {
            return redirect('/admin/buffer')->with('Error','Functionality is not available');
        }
        return view('admin.buffer_edit', compact('editbuffer'));
    }
    public function updatebuffer(Request $request, $id)
    {
    	//$id             = base64_decode($id);
    	 $editaudio   = basic_setting::where('id',$id)->first();
        $details              = [
            "funname"    => $request->funname,
            "funcode"    => $request->funcode,
            "fundesc"    => $request->fundesc,
            "funval1"    => $request->funval1,
            "funstatus"  => isset($request->funstatus) ? 1 : 0,
          
        ];
        $funUpdate  = basic_setting::where('id',$id)->update($details);
        if(!$funUpdate)
        {
            return redirect('/admin/buffer')->with('Error','CMS not updated');
        }
        return redirect('/admin/buffer')->with('Success','Functionality Updated Sucessfully');
    }
    public function deletebuffer($id)
    {
        $id             = base64_decode($id);
        $deletebuffer = basic_setting::where([['id', $id]])->delete();
       
        if(!$deletebuffer)
        {
            return redirect('/admin/buffer')->with('Error', 'Functionality not deleted');
        }
        return redirect('/admin/buffer')->with('Success', 'Functionality Deleted Successfully');

        }
}
