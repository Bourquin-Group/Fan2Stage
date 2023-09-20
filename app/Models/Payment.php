<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table ='payment';
    protected $fillable = [
        'user_id',
        'subscriptionplans_id',
        'payment_date',
        'renewal_date',
        'type',
        'payment_status',
        'amount',
        'total',
        'fans_per_event',
        'events_per_month',
        'stripe_product_id',
        'stripe_price_id',
        'stripe_customer_id',
        'stripe_charge_id',
        
    ];
    protected $dates = ['payment_date','renewal_date'];

    public function artistDetail(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function subscriptionPlan(){
        return $this->belongsTo(subscriptionplan::class,'subscriptionplans_id');
    }
}
