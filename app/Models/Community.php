<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'name', 'photo', 'author_id', 'user_id'];
    
    public function setUser_idAttribute($value)
    {
        $this->attributes['user_id'] = json_encode($value);
    }
    public function gettUser_idAttribute($value)
    {
        $this->attributes['user_id'] = json_decode($value);
    }
}
