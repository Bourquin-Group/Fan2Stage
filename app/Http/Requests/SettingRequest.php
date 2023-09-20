<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class SettingRequest extends FormRequest
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
        //dd($this);

        $rules = [];
        if ($this->isMethod('post')) {
            $rules =
                [
                    'title'       => 'required',
                    'slug'       => 'required|unique:settings,key,'.$this->route('id'),
                    'description' => 'required',
                    'category'        => 'required',
                    
                ];
        }
        if ($this->isMethod('put')) {
            $rules =
                [
                    'title'       => 'required',
                    'slug'       => 'required|unique:settings,key,'.$this->route('id'),
                    'description' => 'required',
                    'category'        => 'required',
                ];
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'title.required'      => 'Please Enter Name',
            'slug.required'      => 'Please Enter your key',
            'slug.unique'               => 'Key is Already Exit',
            'description.required'        => 'Please Enter Value',
            'category.required'             => 'Please Select Category',
            
            
        ];
    }
}
