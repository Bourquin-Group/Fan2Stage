<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AudioFile;
use Image;

class AudioController extends Controller
{
    public function audio(Request $request)
    {
    	$audio = AudioFile::all();
    	return view('admin.audiolist', compact('audio'));
    }
     public function audiocreation(Request $request)
    {
    	return view('admin.audio_manage');
    }
     public function audiostore(Request $request)
    {
        $validatedData = $request->validate([
            'audio_name' => 'required',
            'audio_type' => 'required',
            'block' => 'required',
            'factcount' => 'required|numeric',
            'tactcount' => 'required|numeric',
            'audio_file' => 'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav'
        ], [
            'name.required' => 'Audio name is required',
            'factcount.required' => 'From action count is required',
            'factcount.numeric' => 'From action count must be numeric.',
            'tactcount.required' => 'To action count is required',
            'tactcount.numeric' => 'To action count must be numeric.',
            'audio_type.required' => 'Please Select Audio Type',
            'block.required' => 'Please Select Block',
        ]);



        $audiofile = $request->file('audio_file');
     $audiofilename = $audiofile->getClientOriginalName();
   if (!file_exists(public_path('assets/graph/audio/')))
     mkdir(public_path('assets/graph/audio/'), 0777, true);

     $destinationPath_2 = public_path('assets/graph/audio/');
     $audiofile->move($destinationPath_2, $audiofilename);
        $details              = [
            "audio_name"    => $request->audio_name,
            "audio_type"    => $request->audio_type,
            "block"    => $request->block,
            "factcount"    => $request->factcount,
            "tactcount"    => $request->tactcount,
            "audio_file"     => $audiofilename,
            "audio_status"     => 1,
        ];
         $supplier_array        = AudioFile::create($details);
        return redirect('/admin/audio')->with('Success', 'Audio File Added Successfully.');
    }

        public function editaudio($id)
    {
      
        $id             = base64_decode($id);
        $editaudio   = AudioFile::where('id',$id)->first();
        if(!$editaudio)
        {
            return redirect('/admin/audio')->with('Error','Audio File is not available');
        }
        return view('admin.audio_edit', compact('editaudio'));
    }
    public function updateaudio(Request $request, $id)
    {
    	//$id             = base64_decode($id);
    	 $editaudio   = AudioFile::where('id',$id)->first();


    
         $audiofile = $request->file('audio_file');
         if($audiofile != null){
            $audiofilename = $audiofile->getClientOriginalName();
            if (!file_exists(public_path('assets/graph/audio/')))
              mkdir(public_path('assets/graph/audio/'), 0777, true);
         
              $destinationPath_2 = public_path('assets/graph/audio/');
              $audiofile->move($destinationPath_2, $audiofilename);
         }
        

        $details              = [
            "audio_name"    => $request->audio_name,
            "audio_type"    => $request->audio_type,
            "block"    => $request->block,
            "factcount"    => $request->factcount,
            "tactcount"    => $request->tactcount,
            "audio_file"     => isset($audiofilename)?$audiofilename:$editaudio->audio_file,
            "audio_status"         => isset($request->audio_status) ? 1 : 0,
          
        ];
        $introductoryUpdate  = AudioFile::where('id',$id)->update($details);
        if(!$introductoryUpdate)
        {
            return redirect('/admin/audio')->with('Error','CMS not updated');
        }
        return redirect('/admin/audio')->with('Success','Audio Files Updated Sucessfully');
    }
    public function deleteaudio($id)
    {
        $id             = base64_decode($id);
        $deleteaudio = AudioFile::where([['id', $id]])->delete();
       
        if(!$deleteaudio)
        {
            return redirect('/admin/audio')->with('Error', 'Audio not deleted');
        }
        return redirect('/admin/audio')->with('Success', 'Audio Deleted Successfully');

        }
}
