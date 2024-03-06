<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Laravel\Cashier\Billable;


class User extends Authenticatable implements MustVerifyEmail
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;
    // use HasApiTokens, HasFactory, Notifiable , Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'country_code',
        'phone_number',
        'stage_name',
        'email',
        'password',
        'social_id',
        'social_type',
        'user_type',
        'typeupgrade_status',
        'verified_profile',
        'device_token',
        'session_id',
        'status',
        'last_login',
        'password_otp',
        'image',
        'preferred_genre',
        'timezone',
        'dob',
        'uuid',
        'billinginfo',
        'newsletter',
        'subscription_plan_id',
        'current_payment_id'
    ];
    protected $dates = ['last_login'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

       public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::random(15);

          
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function subscriptionPlan()
    {
        return $this->belongsTo(subscriptionplan::Class,'subscription_plan_id');
    }

    public function currentPayment()
    {
        return $this->belongsTo(Payment::Class,'current_payment_id');
    }

    public function image()
    {
        return asset('/fans_profile_images/'.$this->image);
    }

    public function artistProfile()
    {
        return $this->hasOne(Artist_profiles::Class,'user_id');
    }
    
    public function profile()
    {  
        $path =asset('artist_profile_images/profile1.jpeg');
        if (optional(auth()->user())->image && File::exists(public_path('fans_profile_images/'.optional(auth()->user())->image))) {
           $path = asset('fans_profile_images/'.optional(auth()->user())->image);
        }
        return $path; 
    }
   
}
