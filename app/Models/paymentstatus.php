<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymentstatus extends Model
{
    use HasFactory;
    protected $table ='paymentstatus';
    protected $fillable = [
        'user_id',
        'payment_id',
        'payment_status',
        'description',
        'status',
    ];
}
