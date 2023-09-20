<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActions extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id','artist_id','event_id','action_type','count',
    ];
    public function userDetail(){
        return $this->hasMany(User::class,'id','user_id');
    }
    public function eventDetail(){
        return $this->hasMany(Event::class,'id','event_id');
    }
    public function artistDetail(){
        return $this->hasMany(Artist::class,'id','artist_id');
    }
    public function actionDetail(){
        return $this->hasMany(Actions::class,'id','action_type');
    }
}
