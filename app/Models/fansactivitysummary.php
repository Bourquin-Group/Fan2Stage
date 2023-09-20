<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fansactivitysummary extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'event_id','artist_id','activitytime','actid1','actid2','actid3','actid4','actid5','actid6','activitystatus','lastsumtime',
    ];
    public function eventDetail(){
        return $this->hasMany(Event::class,'event_id');
    }
    public function artistDetail(){
        return $this->hasMany(Artist::class,'artist_id');
    }
}
