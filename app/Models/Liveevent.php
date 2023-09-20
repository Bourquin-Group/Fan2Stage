<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liveevent extends Model
{
    use HasFactory;
    protected $table = 'liveevent';
    protected $fillable = [
        'title', 'description','user_id'
    ];
}
