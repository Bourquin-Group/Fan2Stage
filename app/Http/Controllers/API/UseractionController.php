<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserActions;
class UseractionController extends Controller
{

    public function getUseraction(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'artist_id' => 'required',
            'event_id' => 'required',
            'action_type' => 'required',
            'count' => 'required',
        ]);
   
        if($validator->fails()){
            return response()->json([
                'message' => 'Invalid params passed',
                  'errors' => $validator->errors()
              ], 422);        
        }
        $inputs = [ 
            'user_id' => $request->user_id,
            'event_id' => $request->event_id,
            'artist_id' => $request->artist_id,
            'action_type' => $request->action_type,
            'count' => $request->count,
        ];
            $Event = UserActions::create($inputs);
            $response = [
                'success'   => true,
                'message' => 'User Actions Stored Successfully',
            ];
            return response()->json($response, 200);
    }
}
