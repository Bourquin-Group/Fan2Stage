<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id','artist_id','event_id','amount','status',
    ];
    public function userDetail(){
        return $this->hasMany(User::class,'id','user_id');
    }
    public function eventDetail(){
        return $this->hasMany(Event::class,'id','user_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
