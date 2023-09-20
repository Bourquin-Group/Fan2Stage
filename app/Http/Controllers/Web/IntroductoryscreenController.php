<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IntroductoryscreenController extends Controller
{
    public function introductory(Request $request){
        $intro_screendata = app('App\Http\Controllers\API\IntroductoryscreenController')->introductoryScreen();
        $intro_screendataArray = json_decode ($intro_screendata->content(), true);
        $intro_screendata = $intro_screendataArray['data'];
        return view('introductoryscreen.content',compact('intro_screendata'));
    }
}
