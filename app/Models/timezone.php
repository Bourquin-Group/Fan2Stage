<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class timezone extends Model
{
    use HasFactory;
    protected $fillable = [
        'region','timezone',
    ];
}
