<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class timezone_change extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'modify_date',
        'status',
    ];
}
