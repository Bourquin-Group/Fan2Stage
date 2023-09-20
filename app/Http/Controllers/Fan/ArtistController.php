<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function artistprofile($id){
        $id = base64_decode($id);
        $artistdetail = app('App\Http\Controllers\API\ArtistController')->apiArtistDetail($id);
        $artistdetailArray = json_decode ($artistdetail->content(), true);
        $profile = $artistdetailArray['profile'];
        $live_event = $artistdetailArray['live_event'];
        $sceduled_event = $artistdetailArray['sceduled_event'];
        
        return view('fanweb.artistprofile',compact('profile','live_event','sceduled_event'));
    }   
}
