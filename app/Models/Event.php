<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id','event_title','event_date','event_time','eventstarttime','eventendtime','event_timezone','link_to_event_stream','eventamount','event_duration','ratings','event_status','event_count','event_plan_type','event_image','genre','event_description','golivestatus',
    ];
    protected $dates =  ['event_date'];
    public function userDetail(){
        return $this->belongsTo(User::class,'user_id','id');
        // return $this->belongsTo(User::class,'user_id','id')->where('user_type','artists')->orWhere('user_type','admin');
    }
    public function eventBooking(){
        return $this->belongsTo(Eventbooking::class,'id','event_id');
    }
    public function Eventratings(){
        return $this->belongsTo(Event_joined_by_fans::class,'id','event_id');
    }
    public function eventBookingList(){
        return $this->hasMany(Eventbooking::class,'event_id');
    }

    public function eventJoinedByFans(){
        return $this->hasMany(Event_joined_by_fans::class,'event_id');
    }

    public function donation(){
        return $this->hasMany(Donation::class,'event_id');
    }
    public function event(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    
}
