<?php

namespace App\Models;

use App\Models\User;
use App\Models\Event;
use App\Models\Favourite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';
    protected $fillable = ['description','event_id','favourite_id','event_booking_id','status','type','user_id'
    ];

    public function event(){
        return $this->belongsTo(Event::class,'event_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function favourite(){
        return $this->belongsTo(Favourite::class,'favourite_id');
    }

    public function eventBooking(){
        return $this->belongsTo(Eventbooking::class,'event_booking_id');
    }
}
