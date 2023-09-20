<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    public function aboutUs(Request $request){
        
        $aboutus = app('App\Http\Controllers\API\CmsManageController')->aboutus();
        $aboutusArray = json_decode ($aboutus->content(), true);
        $aboutus = $aboutusArray['data'];

        $privacypolicy = app('App\Http\Controllers\API\CmsManageController')->privacypolicy();
        $privacypolicyArray = json_decode ($privacypolicy->content(), true);
        $privacypolicy = $privacypolicyArray['data'];

        $termsandcondition = app('App\Http\Controllers\API\CmsManageController')->termsandcondition();
        $termsandconditionArray = json_decode ($termsandcondition->content(), true);
        $termsandcondition = $termsandconditionArray['data'];
        
       
        return view('settings.cmscontent',compact('aboutus','termsandcondition','privacypolicy'));
    }
}
