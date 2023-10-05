<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class timezone_notify extends Model
{
    use HasFactory;
    protected $fillable = [
        'timezone_desc',
        'modify_date',
        'date',
    ];
}
