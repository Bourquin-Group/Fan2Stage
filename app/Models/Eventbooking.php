<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventbooking extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id','artist_id','event_id','amount','status','payment_status','event_status','joinEvent_Time','exitEvent_Time'
    ];
    public function userDetail(){
        return $this->hasMany(User::class,'id','user_id');
    }
    public function eventDetail(){
        return $this->belongsTo(Event::class,'event_id','id');
    }
    public function artist(){
        return $this->belongsTo(User::class,'artist_id');
    }
    public function event(){
        return $this->belongsTo(Event::class,'event_id');
    }
}
