<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contactcms;

class ContactManageController extends Controller
{
    public function contactcms(Request $request)
    {
    	$contact = Contactcms::all();
    	return view('admin.contactlist', compact('contact'));
    }
    
        public function editContact($id)
    {
      
        $id             = base64_decode($id);
        $editcontact   = Contactcms::where('id',$id)->first();
        if(!$editcontact)
        {
            return redirect('/admin/Contactcms')->with('Error','Audio File is not available');
        }
        return view('admin.contact_edit', compact('editcontact'));
    }
    public function updateContact(Request $request, $id)
    {
    	 $editcontact   = Contactcms::where('id',$id)->first();
        $details              = [
            "title1"    => $request->title1,
            "title2"    => $request->title2,
            "email"    => $request->email,
            "phone"    => $request->phone,
            "location"    => $request->location,
            "map"    => $request->map,
            "status"         => isset($request->contact_status) ? 1 : 0,
          
        ];
        $contactUpdate  = Contactcms::where('id',$id)->update($details);
        if(!$contactUpdate)
        {
            return redirect('/admin/contactcms')->with('Error','Contact not updated');
        }
        return redirect('/admin/contactcms')->with('Success','Contact Updated Sucessfully');
    }
    public function deleteContact($id)
    {
        $id             = base64_decode($id);
        $deletecontact = Contactcms::where([['id', $id]])->delete();
       
        if(!$deletecontact)
        {
            return redirect('/admin/contactcms')->with('Error', 'Contact not deleted');
        }
        return redirect('/admin/contactcms')->with('Success', 'Contact Deleted Successfully');

        }
    
}
