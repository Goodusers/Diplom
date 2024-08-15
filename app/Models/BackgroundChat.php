<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackgroundChat extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'chat_id',
        'image',
    ];
}
