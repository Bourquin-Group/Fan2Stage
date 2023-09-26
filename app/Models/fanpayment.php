<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fanpayment extends Model
{
    use HasFactory;
    protected $table ='fanpayment';
    protected $fillable = [
        'user_id',
        'event_id',
        'payment_date',
        'type',
        'payment_status',
        'amount',
        'total',
        'stripe_product_id',
        'stripe_price_id',
        'stripe_customer_id',
        'stripe_charge_id',
        
    ];
    protected $dates = ['payment_date'];

    public function fanDetail(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function eventDetail(){
        return $this->belongsTo(Event::class,'event_id');
    }
    public function subscriptionPlan(){
        return $this->belongsTo(subscriptionplan::class,'subscriptionplans_id');
    }
    public function userDetail(){
        return $this->belongsTo(User::class,'user_id','id');
        // return $this->belongsTo(User::class,'user_id','id')->where('user_type','artists')->orWhere('user_type','admin');
    }
}
