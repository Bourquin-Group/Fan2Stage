<?php

namespace App\Http\Controllers\API;

use App\Models\Favourite;
use App\Models\Notification;
use App\Models\Artist_profiles;
use App\Models\User;
use App\Models\Event_joined_by_fans;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class FavouritesController extends Controller
{
    public function addFavourite(Request $request){
        $user = Auth::user();
        $artist_id = $request->artist_id;
        $checkStatus = Favourite::where('user_id',$user->id)->where('artist_id',$artist_id)->first();
        if($checkStatus == null){
            $favourite =Favourite::create([
                'user_id' => $user->id,
                'artist_id' => $artist_id,
                'status' => 1,
            ]);
            Notification::create(['favourite_id' => $favourite->id, 'type' =>1, 'user_id' => $user->id]);
            $favourite = 'fill';
            $response = [
                'success'   => true,
                'user_id'   => $user->id,
                'artist_id' => $artist_id,
                'favourite' => $favourite,
            ];
            return response()->json($response, 200);
        } else{
            $id = $checkStatus->id;
            Favourite::find($id)->delete(); 
            Notification::where('favourite_id',$id)->delete(); 
            $favourite = 'unfill';
            $response = [
                'success'   => true,
                'user_id'   => $user->id,
                'artist_id' => $artist_id,
                'favourite' => $favourite,
            ];
            return response()->json($response, 200);        
        }
    }
    public function listFavourite(){
        $user = Auth::user();
        $favouriteList = Favourite::with('userDetail')->where('user_id',$user->id)->get();
        $checkData = $favouriteList->isNotEmpty();
        $data = [];$allData = [];
        if($checkData == true){
            foreach ($favouriteList as $value) {
                $review =Event_joined_by_fans::where('user_id',$value->artist_id)->get();
                $raiting =0;
                if($review->isNotEmpty())
                {
                    $raiting = ceil($review->sum('ratings')/$review->count());
                }
              
                $data['artist_id'] = $value->artist->id;
                $data['artist_name'] = $value->artist->name;
                $checkuser = User::where('id',$value->artist->id)->where('user_type','artists')->first();
                $artistprofile = Artist_profiles::where('user_id',$value->artist->id)->first();
                if($checkuser){
                    $profile = url('').'/artist_profile_images/'.$artistprofile->profile_image;
                }else{
                    $profile = "";
                }
                $data['artist_profile'] =  $profile;  
                $data['genre'] = (isset($artistprofile->genre)) ? $artistprofile->genre : '';
                $data['rating'] = $raiting;
                $allData[] = $data;
            }           
            $response = [
                'success'   => true,
                'message' => 'Favourite Artist Retrived Sucessfully',
                'data'   => $allData,
            ];
            return response()->json($response, 200);   
        } else{         
            $response = [
                'success'   => false,
                'message' => 'No Favourite Artist Found',
                'data'   => $data,
            ];
            return response()->json($response, 200);    
        }
    }
}
