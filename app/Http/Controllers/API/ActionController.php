<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Actions;

class ActionController extends Controller
{
    public function actionall()
    {
        $events = Actions::all();
            foreach($events as $i => $value){
                $data['actions'][$i]['id'] = $value->id;
                $data['actions'][$i]['audio'] = $value->audio;
                $data['actions'][$i]['image'] = $value->image;
            }
        $response = [
            'status' => 200,
            'success' => true,
            'data'    => $data,
        ];
        return response()->json($response, 200);
    }
    
    public function actioncreate(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'action_audio' => 'required|file|mimes:audio/mpeg,mpga,mp3,wav,aac',
            'action_image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid params passed', // the ,message you want to show
                  'errors' => $validator->errors()
              ], 422);
      
        }
        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors());       
        // }
        $file = $request->file('action_image') ;
            $fileName = $file->getClientOriginalName() ;
            $destinationPath = public_path().'/actionimages' ;
            if($file->move($destinationPath,$fileName)){
                $audio = $request->file('action_audio') ;
            $audioName = $audio->getClientOriginalName() ;
            $destinationPath = public_path().'/actionaudios' ;
            $audio->move($destinationPath,$audioName);
            $inputs = [ 
                'audio' => $audioName,
                'image' => $fileName,
            ];
                $Actions = Actions::create($inputs);
            }
            $response = [
                'status' => 200,
                'success'   => true,
                'message' => 'Action created successfully',
            ];
            return response()->json($response, 200);
    }
    public function actionupdate(Request $request, $id)
    {

                $input = $request->all();
                $validator = Validator::make($input, [
                    'action_audio' => 'required|file|mimes:audio/mpeg,mpga,mp3,wav,aac',
                    'action_image' => 'required',
                ]);
 
                if($validator->fails()){
                    return response()->json([
                        'message' => 'Invalid params passed', // the ,message you want to show
                          'errors' => $validator->errors()
                      ], 422);     
                }
                $file = $request->file('action_image') ;
                $fileName = $file->getClientOriginalName() ;
                $destinationPath = public_path().'/actionimages' ;
                if($file->move($destinationPath,$fileName)){
                    $audio = $request->file('action_audio') ;
                    $audioName = $audio->getClientOriginalName() ;
                    $destinationPath = public_path().'/actionaudios' ;
                    $audio->move($destinationPath,$audioName);
                $action = Actions::where('id',$id)->first();
                if($action){

                    $action->audio = $audioName;
                    $action->image = $fileName;
                    $action->save();
                    return response()->json([
                        'status' => 200,
                        'success' => true,
                        'message' => 'Action updated successfully',
                        'data' => $action
                    ]);
                }else{
                    return response()->json([
                        'status' => 404,
                        'success' => false,
                        'message' => 'Action not updated successfully',
                    ]);
                }
                }
                else{
                    return response()->json([
                        'status' => 404,
                        'success' => false,
                        'message' => 'Action Image not updated successfully',
                    ]);
                }
    }
    public function eventshow($id)
    {
            $action = Actions::where('id',id)->get();
                if (is_null($action)) {
                    return response()->json([
                        'status' => 404,
                        'success' => false,
                        'message' => 'Action Not Found',
                        'data' => []
                    ]);
                }
            $data=[
                'event_title' => $action->audio,
                'event_title' => $action->image,
            ];
            return response()->json([
                'status' => 200,
				'success' => true,
                'message' => 'Action retrieved successfully',
                'data' => $data
			]);
    }
    public function actiondestroy($id)
    {
   
        $Action = Actions::where('id',$id)->first();
        if($Action){

            $Action->delete();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Action deleted successfully',
                'data' => []
            ]);
        }
        else{
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Action Not deleted',
                'data' => []
            ]);
        }
    }
}
