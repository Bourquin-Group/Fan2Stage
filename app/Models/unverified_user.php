<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class unverified_user extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'country_code',
        'phone_number',
        'email',
        'password',
        'timezone',
        'user_type',    
        'status',
        'uuid',
        'password_otp',
        'otp_expire_time',
    ];

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
}
