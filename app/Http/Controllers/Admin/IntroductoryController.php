<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\introductory;
use Image;
class IntroductoryController extends Controller
{
     public function introductory(Request $request)
    {
    	  $introductory = introductory::all();
    	 //printf($data)
    	return view('admin.introductorylist', compact('introductory'));
    }
     public function introductorycreation(Request $request)
    {
        //$country   = country::all();
    	return view('admin.introductory_manage');
    }
     public function introductorystore(Request $request)
    {
    // 	$this->validate($request,
    //  [
      
    //    "title" =>"required",
    //    "link" =>"required",
    //    "description" =>"required",
    //   "image"  => "mimes:jpeg,png,jpg",
    //   //"video"  => "mimes:mp4,mov,ogg",
    //   "video" => "required|file|mimetypes:video/mp4",
    // ]);
        //dd($request);
        $image = $request->file('image');
         $video = $request->file('video');
     $imgfilename = time().'.'.$image->getClientOriginalExtension();
   if (!file_exists(public_path('assets/images/introductory/')))
     mkdir(public_path('assets/images/introductory/'), 0777, true);
     if (!file_exists(public_path('assets/images/introductory/thumbnail/')))
     mkdir(public_path('assets/images/introductory/thumbnail/'), 0777, true);
     //thumbnail
       $destinationPath = public_path('assets/images/introductory/thumbnail');
     $img = Image::make($image->getRealPath());     
     $img->resize(100, 100);
     $img->save($destinationPath.'/'.$imgfilename);  

     $destinationPath_2 = public_path('assets/images/introductory/');
     $image->move($destinationPath_2, $imgfilename);


     
        
     $videofilename = time().'.'.$video->getClientOriginalExtension();
   if (!file_exists(public_path('assets/video/introductory/')))
     mkdir(public_path('assets/video/introductory/'), 0777, true);
     ;  

     $destinationPath_2 = public_path('assets/video/introductory/');
     $video->move($destinationPath_2, $videofilename);

        $details              = [
            "title"    => $request->title,
            "link"    => $request->slug,
            "description"     => $request->description,
          

     
        ];

        $details['image'] =  $imgfilename;
         $details['video'] =  $videofilename;


         $supplier_array        = introductory::create($details);
        return redirect('/admin/introductory')->with('Success', 'Introductory Added Successfully.');
    }

        public function editintroductory($id)
    {
      
        $id             = base64_decode($id);
        $editintroductory   = introductory::where('id',$id)->first();
       // $countryselect =  User::where('id',$id)->first();
        //$country   = country::all();
        if(!$editintroductory)
        {
            return redirect('/admin/introductory')->with('Error','CMS id is not available');
        }
       
        return view('admin.introductory_edit', compact('editintroductory'));
    }
    public function updateintroductory(Request $request, $id)
    {
    	//$id             = base64_decode($id);
    	 $editintroductory   = introductory::where('id',$id)->first();
if($request->hasFile('image')){
$image = $request->file('image');
        
     $imgfilename = time().'.'.$image->getClientOriginalExtension();
   if (!file_exists(public_path('assets/images/introductory/')))
     mkdir(public_path('assets/images/introductory/'), 0777, true);
     if (!file_exists(public_path('assets/images/introductory/thumbnail/')))
     mkdir(public_path('assets/images/introductory/thumbnail/'), 0777, true);
     //thumbnail
       $destinationPath = public_path('assets/images/introductory/thumbnail');
     $img = Image::make($image->getRealPath());     
     $img->resize(100, 100);
     $img->save($destinationPath.'/'.$imgfilename);  

     $destinationPath_2 = public_path('assets/images/introductory/');
     $image->move($destinationPath_2, $imgfilename);
 }


     if($request->hasFile('video')){
         $video = $request->file('video');
     $videofilename = time().'.'.$video->getClientOriginalExtension();
   if (!file_exists(public_path('assets/video/introductory/')))
     mkdir(public_path('assets/video/introductory/'), 0777, true);
     ;  

     $destinationPath_2 = public_path('assets/video/introductory/');
     $video->move($destinationPath_2, $videofilename);
 }
        $details              = [
           "title"    => $request->title,
            "link"    => $request->slug,
            "description"     => $request->description,
            "status"         => ($request->has('status') == true) ? 1 : 0,
          
        ];
//dd(  $details );
        $details['image'] =  isset($imgfilename)?$imgfilename:$editintroductory->image;
         $details['video'] = isset($videofilename)?$videofilename:$editintroductory->video; 
        $introductoryUpdate  = introductory::where('id',$id)->update($details);
        if(!$introductoryUpdate)
        {
            return redirect('/admin/introductory')->with('Error','CMS not updated');
        }
        return redirect('/admin/introductory')->with('Success','Introductory Updated Sucessfully');
    }
    public function deleteintroductory($id)
    {
        $id             = base64_decode($id);
        $deleteintroductory = introductory::where([['id', $id]])->delete();
       
        if(!$deleteintroductory)
        {
            return redirect('/admin/introductory')->with('Error', 'Introductory not deleted');
        }
        return redirect('/admin/introductory')->with('Success', 'Introductory Deleted Successfully');

        }
}
