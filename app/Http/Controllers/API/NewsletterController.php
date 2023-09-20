<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Eventbooking;
use App\Models\User;
use App\Models\Favourite;
use App\Models\Newsletters;
use Newsletter;
class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newsall()
    {
		
        $events = Newsletter::all();
        $data = [];
            foreach($events as $i => $value){
                $data['events'][$i]['id'] = $value->id;
                $data['events'][$i]['email'] = $value->email;
            }
            if($data){
                $response = [
                    'success' => true,
                    'data'    => $data,
                ];
                return response()->json($response, 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'No Newsletter Found',
                ]);
            }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newscreate(Request $request)
    {
       
        // $validatedData = $request->validate([
        //     'email' => ['required','regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/','unique:newsletters']
        // ],[
        //     'email.required'=> 'Please Enter Your Email',
        //     'email.regex'=> 'Invalid Email Address',
        //     'email.unique'=> 'This Email Already Exist ',
        // ]);


        // $validator = Validator::make($input, [
        //     'email' => 'required|unique:newsletters'
        // ]);
   
        // if($validator->fails()){
        //     return response()->json(['success' => false, 'error' => $validator->errors()->toArray()],401);
        // }
    
        $inputs = [ 
            'email' => $request->email,           
            'user_id' => auth()->user()->id	
        ];
        $emailexist = Newsletters::where('email',$request->email)->first();
        if($emailexist){
            $emailexist->email = $request->email;
            $emailexist->save();
        }else{
            $News = Newsletters::create($inputs);
        }
	
        

         if(! Newsletter::isSubscribed($request['email'])){
            Newsletter::subscribe($request['email']);
            $newsletter = 1;
         }else{
            $newsletter = 0;
         }
         $user = User::where('id',auth()->user()->id)->first();
         $user->newsletter = $newsletter ;
         $user->save();
            $response = [
                'status' => 200,
                'success'   => true,
                'message' => 'Newsletter created successfully',
            ];
            return response()->json($response, 200);
        }
    }


