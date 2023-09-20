<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserManagementRequest extends FormRequest
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
                    'name'       => 'required',
                    'ccode' => 'required',
                    'phone'       => 'required|digits:10|unique:users,phone_number,'.$this->route('id'),
                    //'stage'         => 'required|unique:users,stage_name,'.$this->route('id'),
                    'email'         => 'required|email:rfc,dns|unique:users,email,'.$this->route('id'),
                    'password'        => 'required',
                    
                ];
        }
        if ($this->isMethod('put')) {
            $rules =
                [
                    'name'       => 'required',
                    'ccode' => 'required',
                    'phone'       => 'required|digits:10|unique:users,phone_number,'.$this->route('id'),
                    //'stage'         => 'required|unique:users,stage_name,'.$this->route('id'),
                    'email'         =>  'required|email:rfc,dns|unique:users,email,'.$this->route('id'),
                    'password'        => 'required',
                ];
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'name.required'      => 'Please Enter Your Name',
            'ccode.required'      => 'Please Select Your Country Code',
            'phone.required'        => 'Please Enter Your Phone Number',
            'phone.unique'               => 'Phone Number is Already Registered',
            //'stage.required'        => 'Please Enter Your Stage Name',
           // 'stage.unique'               => 'Stage Name is Already Exit',
            'email.required'             => 'Please Enter Your Email Address',
            'email.email'                => 'Invalid Email',
            'email.unique'               =>  'Email Has Already Created',
            'password.required'        => 'Please Enter Your Password',
            
        ];
    }
}
