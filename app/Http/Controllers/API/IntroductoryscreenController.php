<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\introductory;

class IntroductoryscreenController extends Controller
{
    public function introductoryScreen()
    {
        $introductory = introductory::all();
        if(count($introductory) > 0){
            $data=[
                'Title' => $introductory[0]['title'],
                'Link' => $introductory[0]['link'],
                'Description' => $introductory[0]['description'],
                'Image' => $introductory[0]['image'],
                'Video' => $introductory[0]['video'],
            ];
        $response = [
            'status' => 200,
            'success' => true,
            'data'    => $data,
        ];
        return response()->json($response, 200);
        }else{
            $response = [
                'status' => 404,
                'success' => false,
                'message' => "No Data Found"
            ];
            return response()->json($response, 200);
        }
    }
    
}
