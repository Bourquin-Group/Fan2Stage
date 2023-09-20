<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\cms_manage;
class CmsManageController extends Controller
{
      public function aboutus()
    {
        $content = cms_manage::where('slug','about-us')->where('status',1)->get();
        if(count($content) > 0){
        
            $data=[
                'Title' => $content[0]['title'],
                'Slug' => $content[0]['slug'],
                'Description' => $content[0]['description'],
            ];
        $response = [
            'status' => 200,
            'success' => true,
            'data'    => $data,
        ];
        return response()->json($response, 200);
    }else{
        $data=[
            'Title' => 'About US',
            'Slug' => '',
            'Description' => 'No Data',
        ];
        $response = [
            'status' => 404,
            'success' => false,
            'data'    => $data,
            'message' => "No Data Found"
        ];
        return response()->json($response,404);
    }
    }

       public function privacypolicy()
    {
        $content = cms_manage::where('slug','privacy-policy')->where('status',1)->get();
        $data = [];
        if(count($content) > 0){
            $data=[
                'Title' => $content[0]['title'],
                'Slug' => $content[0]['slug'],
                'Description' => $content[0]['description'],
            ];
        $response = [
            'success' => true,
            'data'    => $data,
        ];
        return response()->json($response, 200);
        }else{
            $data=[
                'Title' => 'Privacy Policy',
                'Slug' => '',
                'Description' => 'No Data',
            ];
            $response = [
                'status' => 404,
                'success' => false,
                'data'    => $data,
                'message' => "No Data Found"
            ];
            return response()->json($response, 404);
        }
    }

       public function termsandcondition()
    {
        $data = [];
        $content = cms_manage::where('slug','terms-and-condition')->where('status',1)->get();
        if(count($content) > 0){
                $data=[
                    'Title' => $content[0]['title'],
                    'Slug' => $content[0]['slug'],
                    'Description' => $content[0]['description'],
                ];
                    $response = [
                        'success' => true,
                        'data'    => $data,
                    ];
                    return response()->json($response, 200);
                }else{
                    $data=[
                        'Title' => 'Terms And Condition',
                        'Slug' => '',
                        'Description' => 'No Data',
                    ];
                    $response = [
                        'status' => 404,
                        'success' => false,
                        'data'    => $data,
                        'message' => "No Data Found"
                    ];
                    return response()->json($response, 404);
                }
    }
}
