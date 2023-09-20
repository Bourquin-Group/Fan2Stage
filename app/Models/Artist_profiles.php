<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artist_profiles extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id','stage_name','bio','genre','ratings','website_link','itunes_link','youtube_link','instagram_link','facebook_link','profile_image','landing_page_image',
    ];
    public function userArtist(){
        return $this->belongsTo(User::class,'user_id')->where('user_type','artists');
    }
    public function Artistratings(){
        return $this->belongsTo(Event_joined_by_fans::class,'user_id','artist_id');
    }
    public function Artistevent(){
        return $this->belongsTo(Event::class,'user_id','user_id');
    }

    public function profile()
    {  
        $path =asset('artist_profile_images/profile1.jpeg');
        if ($this->profile_image && File::exists(public_path('artist_profile_images/'.$this->profile_image))) {
           $path = asset('artist_profile_images/'.$this->profile_image);
        }
        return $path; 
    }


    public function landingPage()
    {  
        $path =asset('assets/fan/images/homepage-bg.png');
        if ($this->profile_image && File::exists(public_path('artist_landingpage_images/'.$this->landing_page_image))) {
           $path = asset('artist_landingpage_images/'.$this->landing_page_image);
        }
        return $path; 
    }


}
    