<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class basic_setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'funname',
        'funcode',
        'fundesc',
        'funval1',
        'funstatus',
        'created_by',
        ];
}
