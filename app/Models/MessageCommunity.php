<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageCommunity extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'image',
        'username',
        'user_photo',
        'file'
    ];
}
