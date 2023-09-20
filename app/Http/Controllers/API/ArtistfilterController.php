<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Models\Artist_profiles;
use App\Http\Controllers\Controller;
use App\Models\Event_joined_by_fans;
use Illuminate\Support\Facades\Auth;


class ArtistfilterController extends Controller
{

    public function artistFilter(Request $request)
    {
     
        $user = Auth::user();
        if($request["type"] == 'artists')
        {
            $artistName = $request["name"];
            $artistrating = $request["rating"];
            $genre = $request["genre"];
            
            $fromdate1 = $request["from_date"];
            $yesterday_date = date("Y-m-d", strtotime("yesterday"));
            $from_date = date("Y-m-d", strtotime($fromdate1));
            if($fromdate1 != NULL){
                if($from_date < $yesterday_date){
                    $fromdate = $yesterday_date;
                }else{
                    $fromdate = $request["from_date"];
                }
            }else{
                $fromdate = NULL;
            }
            
            $todate1 = $request["to_date"];
            $to_date = date("Y-m-d", strtotime($todate1));
            $current_date = date("Y-m-d");
            if($todate1 != NULL){
                if($to_date < $current_date){
                    $todate = date("Y-m-d");
                }else{
                    $todate = $request["to_date"];
                }
            }else{
                $todate = NULL;
            }
            // genre value
            $genrevalue = [];
            if($genre != null){
                foreach($genre as $value){
                    if($value !== NULL && $value !== FALSE && $value !== ""){
                        $genrevalue[]=$value;
                    }
                }
            }
            // rating value
            $ratingvalue = [];
            if($artistrating != null){
                foreach($artistrating as $value){
                    if($value !== NULL && $value !== FALSE && $value !== ""){
                        $ratingvalue[]=$value;
                    }
                }
            }
            $genre = explode(',',$request->ad_genre);
            if(($artistName !== NULL && $artistName !== FALSE && $artistName !== "") || count($genrevalue) > 0|| count($ratingvalue) > 0 || $fromdate !== NULL || $todate !== NULL){
                // dd($genrevalue);
                $artist = Artist_profiles::with('userArtist','Artistratings','Artistevent')
                ->when($artistName,function($q) use($artistName){
                    $q->whereHas('userArtist', function($q) use($artistName)
                    {
                        $q->where( "name",
                        "like",
                        "%" . $artistName . "%");
    
                    });
                })
                ->when($artistName,function($q) use($artistName){
                    $q->whereHas('userArtist', function($q) use($artistName)
                    {
                        $q->where( "name",
                        "like",
                        "%" . $artistName . "%");
    
                    });
                })
                ->where(function($q) use($ratingvalue){
                        $i = 0;
                    foreach ($ratingvalue as $key => $value) {
                     if($i)
                     {
                        $q->orWhereRaw("find_in_set('$value',ratings)");
                      
                     }else{
                        $q->whereRaw("find_in_set('$value',ratings)");
                     }
                     $i++;
                    }
                })
                ->where(function($query) use ($genrevalue) {
                    $i = 0;
                    foreach ($genrevalue as $key => $value) {
                     if($i)
                     {
                        $query->orWhereRaw("find_in_set('$value',genre)");
                      
                     }else{
                        $query->whereRaw("find_in_set('$value',genre)");
                     }
                     $i++;
                    }
                })->when(($fromdate != NULL && $todate == NULL),function($q) use($fromdate){
                    $q->whereHas('Artistevent', function($q) use($fromdate)
                    {
                        $q->where("event_date",$fromdate);
                    });
                })->when(($todate != NULL && $fromdate == NULL),function($q) use($todate){
                    $q->whereHas('Artistevent', function($q) use($todate)
                    {
                        $q->where("event_date",$todate);
                    });
                })->when(($todate != NULL && $fromdate != NULL),function($q) use($todate,$fromdate){
                    $q->whereHas('Artistevent', function($q) use($fromdate,$todate)
                    {
                        $q->whereBetween('event_date', [$fromdate, $todate]);
                    });
                })
                ->get();
                // dd($artist);
                $data = [];
                foreach($artist as $key=>$value){
                     $favourite = Favourite::where('user_id',$user->id)->where('artist_id',$value->user_id)->first();
                    //  $review =Event_joined_by_fans::where('user_id',$value->user_id)->get();
                    // $raiting=0;
                    //  if($review->isNotEmpty())
                    //  {
                    //      $raiting = $review->sum('ratings')/$review->count();
                    //  }
                    //  if(in_array($raiting, $ratingvalue, TRUE) && count($ratingvalue) > 0){
                    // $data[$key]['stage_name']=$value->stage_name;
                    // $data[$key]['genre']=$value->genre;
                    // $data[$key]['website_link']=$value->website_link;
                    // $data[$key]['youtube_link']=$value->youtube_link;
                    // $data[$key]['itunes_link']=$value->itunes_link;
                    // $data[$key]['instagram_link']=$value->instagram_link;
                    // $data[$key]['facebook_link']=$value->facebook_link;
                    // $data[$key]['profile_image']=url('').'/artist_profile_images/'.$value->profile_image;
                    // $data[$key]['profile_image_web']=$value->profile_image;
                    // $data[$key]['artist_name'] = isset($value->userArtist['name']) ? $value->userArtist['name']: '';
                    // $data[$key]['name']=isset($value->userArtist['name']) ? $value->userArtist['name']: '';
                    // $data[$key]['email']=isset($value->userArtist['email']) ? $value->userArtist['email']: '';
                    // $data[$key]['artist_id'] = $value->user_id;
                    // $data[$key]['favourite_status']=$favourite?1:0;
                    // $data[$key]['rating'] = $raiting;
                    //  }else{
                    $data[$key]['stage_name']=$value->stage_name;
                    $data[$key]['genre']=$value->genre;
                    $data[$key]['website_link']=$value->website_link;
                    $data[$key]['youtube_link']=$value->youtube_link;
                    $data[$key]['itunes_link']=$value->itunes_link;
                    $data[$key]['instagram_link']=$value->instagram_link;
                    $data[$key]['facebook_link']=$value->facebook_link;
                    $data[$key]['profile_image']=url('').'/artist_profile_images/'.$value->profile_image;
                    $data[$key]['profile_image_web']=$value->profile_image;
                    $data[$key]['artist_name'] = isset($value->userArtist['name']) ? $value->userArtist['name']: '';
                    $data[$key]['name']=isset($value->userArtist['name']) ? $value->userArtist['name']: '';
                    $data[$key]['email']=isset($value->userArtist['email']) ? $value->userArtist['email']: '';
                    $data[$key]['artist_id'] = $value->user_id;
                    $data[$key]['favourite_status']=$favourite?1:0;
                    $data[$key]['rating'] = ($value->ratings > 0) ? (int)$value->ratings : 0;
                    //  }
                }
                // dd($data);
                if($data){
                    $response = [
                        'status' => 200,
                        'success' => true,
                        'data'    => $data,
                        'message' => 'Artist Details Filtered Succefully',
                    ];
                    return response()->json($response, 200); 
                }else{
                    $response = [
                        'status' => 200,
                        'success' => false,
                        'data'    => $data,
                        'message' => 'No Artist Detail Found',
                    ];
                    return response()->json($response, 200);
                }
            }else{
              
                    $artistDetail = Artist_profiles::with('userArtist')->get();
                    foreach($artistDetail as $value){
                        $favourite = Favourite::where('user_id',$user->id)->where('artist_id',$value->user_id)->first();
                        // $review =Event_joined_by_fans::where('user_id',$value->user_id)->get();
                        // // dd($review);
                        // $raiting =0;
                        // if($review->isNotEmpty())
                        // {
                        //     $raiting = $review->sum('ratings')/$review->count();
                        //     // dd($raiting);
                        // }
                        $data['user_id'] = $value->user_id;
                        $data['stagename'] = $value->stage_name;
                        $data['genre'] = $value->genre;
                        $data['website_link'] = $value->website_link ;
                        $data['itunes_link'] = $value->itunes_link ;
                        $data['youtube_link'] = $value->youtube_link; 
                        $data['instagram_link'] = $value->instagram_link;
                        $data['facebook_link'] = $value->facebook_link;
                        $data['profile_image'] = url('').'/artist_profile_images/'.$value->profile_image;
                        $data['profile_image_web']=$value->profile_image;
                        $data['artist_name'] = isset($value->userArtist['name']) ? $value->userArtist['name']: '';
                        $data['artist_id'] = $value->user_id;
                        $data['favourite_status']=$favourite?1:0;
                        $data['rating'] = ($value->ratings > 0) ? (int)$value->ratings : 0;
                        // $ratings1 = Event_joined_by_fans::where('artist_id',$value->id)->first();
                        // $data['ratings'] = $ratings1->ratings;
                        
                        $artist[]=$data;
                    }
                    // dd($artist);
            
                    if($artist){
                        $response = [
                            'status' => 200,
                            'success'        => true,
                            'message'           => 'Artist Data Retrived Successfully',
                            'data'          => $artist,
                        ];
                        return response()->json($response, 200);
                     }
            }
        }else{
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $request["type"],
            ];
            return response()->json($response, 400);
        }
    }
}
