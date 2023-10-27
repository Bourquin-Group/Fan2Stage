<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificationdetail extends Model
{
    use HasFactory;
    protected $fillable = ['type_name','description','event_id','artist_id','event_booking_id','status','type','read','user_id'
    ];

    public function event(){
        return $this->belongsTo(Event::class,'event_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    // public function favourite(){
    //     return $this->belongsTo(Favourite::class,'favourite_id');
    // }

    public function eventBooking(){
        return $this->belongsTo(Eventbooking::class,'event_booking_id');
    }
}