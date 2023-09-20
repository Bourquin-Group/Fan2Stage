<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'user_id','first_name','last_name','phone','email','comments',
    ];
    public function userArtist(){
        return $this->belongsTo(User::class,'user_id','id')->where('user_type','artists');
    }
}
