<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends BaseController
{
    //
    public function register(Request $request)
            {
                //dd('coming');
               
                $validator = Validator::make($request->all(), [
                    'first_name' => ['required','string','regex:/^[a-z|A-Z]+(?: [a-z|A-Z]+)*$/'],
                    'last_name' => ['required','string','regex:/^[a-z|A-Z]+(?:( |-)[a-z|A-Z]+)*$/'],
                    'country_code' => ['required','regex:/^\+\d{1,2}$/'],
                    'phone_number' => ['required','numeric','digits:10'],
                    'email' => 'required|email',
                    'password' => ['required','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/'],
                    'c_password' => 'required|same:password',
                ]);
 
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors());       
                }

                $request['name'] = $request['first_name'].' '.$request['last_name'];
               
                 //dd($request->all());
                $input = $request->all();
                $input['password'] = bcrypt($input['password']);
                $user = User::create($input);
                $user->name = $request->first_name.' '.$request->last_name;
                $user->save();
                $success['token'] =  $user->createToken('MyApp')->accessToken;
                $success['name'] =  $user->name;
 
                return $this->sendResponse($success, 'User register successfully.');
            }

    public function login(Request $request)
            {
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password]) || Auth::attempt(['phone_number' => $request->email, 'password' => $request->password]) ){ 
                    $user = Auth::user(); 
                    $success['token'] =  $user->createToken('MyApp')->accessToken; 
                    $success['name'] =  $user->name;
 
                    return $this->sendResponse($success, 'User login successfully.');
                } 
                else{ 
                    return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
                } 
            }
}
