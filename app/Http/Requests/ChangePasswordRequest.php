<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        if ($this->isMethod('post')) {
            $rules =
                [
                    'password'       => 'required|min:6',
                   
                    'newpassword' => 'required|min:6|different:password',
                    'confirmpassword' => 'required_with:newpassword|same:newpassword|min:6',
                       
                    // 'ccode' => 'required',
                    // 'phone'       => 'required|digits:10|unique:users,phone_number,'.$this->route('id'),
                    // 'stage'         => 'required|unique:users,stage_name,'.$this->route('id'),
                    // 'email'         => 'required|email:rfc,dns|unique:users,email,'.$this->route('id'),
                   
                    
                ];
        }
        if ($this->isMethod('put')) {
            $rules =
                [
                    'password'       => 'required|min:6',
                   
                    'newpassword' => 'required|min:6|different:old_password',
                    'confirmpassword' => 'required_with:new_password|same:new_password|min:6',
                       
                    
                ];
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'password.required'      => 'Please Enter Your Old Password',
            'newpassword.required'      => 'Please Enter Your New Password',
            'confirmpassword.required'        => 'Please Enter Your Confirm Password',
            
            
            
        ];
    }
}
