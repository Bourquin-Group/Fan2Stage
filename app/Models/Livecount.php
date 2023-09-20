<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livecount extends Model
{
    use HasFactory;
    protected $table ='livecount';
    protected $fillable = [
        'user_id',
        'event_id',
        'eventjoin_date',
        'eventexit_date',
        
    ];
    protected $dates = ['eventjoin_date','eventexit_date'];

    public function fanDetail(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function eventDetail(){
        return $this->belongsTo(Event::class,'event_id');
    }
}
