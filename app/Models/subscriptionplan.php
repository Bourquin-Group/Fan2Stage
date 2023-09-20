<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subscriptionplan extends Model
{
    use HasFactory;
     protected $fillable = [
        'f2s_plan',
        'fans_per_event',
        'events_per_month',
        'push_notification',
        'favorite_link',
        'cost',
        'cost_value',
        'anual_plan',
        'hardware_required',
        'status',
      
        
    ];
}
