<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Models\Liveevent;
use App\Models\Donation;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Liveevent as LiveeventResource;
   
// class LiveeventController extends ResponseController
class LiveeventController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Liveevents = Liveevent::all();
    
        return $this->sendResponse(LiveeventResource::collection($Liveevents), 'Liveevents retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function stores(Request $request)
    {
        // dd(auth()->user()->id);
            $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $inputs = [ 
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->user()->id
        ];
        $Liveevent = Liveevent::create($inputs);
   
        return $this->sendResponse($Liveevent, 'Liveevent created successfully.');
       
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Liveevent = Liveevent::find($id);
  
        if (is_null($Liveevent)) {
            return $this->sendError('Liveevent not found.');
        }
   
        return $this->sendResponse(new LiveeventResource($Liveevent), 'Liveevent retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Liveevent $Liveevent)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $Liveevent->title = $input['title'];
        $Liveevent->detail = $input['description'];
        $Liveevent->save();
   
        return $this->sendResponse(new LiveeventResource($Liveevent), 'Liveevent updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Liveevent $Liveevent)
    {
        $Liveevent->delete();
   
        return $this->sendResponse([], 'Liveevent deleted successfully.');
    }
    public function Donation(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'artist_id' => 'required',
            'event_id' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);
   
        if($validator->fails()){
            return response()->json([
                'message' => 'Invalid params passed', // the ,message you want to show
                  'errors' => $validator->errors()
              ], 422);      
        }
        
        $inputs = [ 
            'artist_id' => $request->artist_id,
            'event_id' => $request->event_id,
            'amount' => $request->amount,
            'status' => $request->status,
            'user_id' => auth()->user()->id
        ];
            $Event = Donation::create($inputs);
            
            $response = [
                'success'   => true,
                'message' => 'Donated successfully',
            ];
            return response()->json($response, 200);
    }

}