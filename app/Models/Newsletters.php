<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletters extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','status','email',
    ];
    /*public function userDetail(){
        return $this->hasMany(User::class,'id','artist_id');
    }*/
}
