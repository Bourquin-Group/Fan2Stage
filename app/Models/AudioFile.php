<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'audio_name',
        'audio_type',
        'audio_file',
        'block',
        'factcount',
        'tactcount',
        'audio_status',
            
        ];
}
