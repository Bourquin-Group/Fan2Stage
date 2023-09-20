<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class billinginformation extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id','address','city','state','country','postalcode',
    ];
    public function userArtist(){
        return $this->belongsTo(User::class,'user_id')->where('user_type','artists');
    }
}
