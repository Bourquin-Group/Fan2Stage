<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class SubscriptionPlanRequest extends FormRequest
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
                    'f2s_plan'       => 'required',
                    //'slug'       => 'required|unique:settings,key,'.$this->route('id'),
                    'fans_per_event' => 'required',
                    'events_per_month'        => 'required',
                    'push_notification'       => 'required',
                    'favorite_link'       => 'required',
                    'cost'       => 'required',
                    "cost_value" => "required_if:cost,==,permonth",
                    'anual_plan'       => 'required',
                    'hardware_required'       => 'required',

                    
                ];
        }
        if ($this->isMethod('put')) {
            $rules =
                [
                    'f2s_plan'       => 'required',
                    //'slug'       => 'required|unique:settings,key,'.$this->route('id'),
                    'fans_per_event' => 'required',
                    'events_per_month'        => 'required',
                    'push_notification'       => 'required',
                    'favorite_link'       => 'required',
                    'cost'       => 'required',
                     "cost_value" => "required_if:cost,==,permonth",
                    'anual_plan'       => 'required',
                    'hardware_required'       => 'required',
                ];
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'f2s_plan.required'      => 'Please Enter F2S Plan',
            'fans_per_event.required'      => 'Please Enter Fans Per Event',
            'events_per_month.required'      => 'Please Enter Events Per Month',
            //'events_per_month.required'      => 'Please Enter Name',
            'push_notification.required'      => 'Please Select Push Notification',
            'favorite_link.required'      => 'Please Select Favorite Link',
            'cost.required'      => 'Please Choose Cost Type',
             'cost_value'      => 'Please Enter The Cast Value',
            'anual_plan.required'      => 'Please Select Anual Plan',
            'hardware_required.required'      => 'Please Choose Hardware Required',

            
            
            
        ];
    }
}
