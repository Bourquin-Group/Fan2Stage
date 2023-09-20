<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'action_name',
        'action_desc',
        'action_file',
        'action_status',
        'created_by',
        'updated_by',
            
        ];
}
