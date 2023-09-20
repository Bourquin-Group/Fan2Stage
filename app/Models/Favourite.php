<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favourite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','artist_id','status',
    ];
    public function userDetail(){
        return $this->hasMany(User::class,'id','artist_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function artist(){
        return $this->belongsTo(User::class,'artist_id');
    }
}
