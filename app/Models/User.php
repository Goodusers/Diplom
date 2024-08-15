<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Message;
use App\Notifications\SendVerify;
use Illuminate\Support\Facades\Hash;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'phone',
        'token',
        'photo',
        'city',
        'role',
        'is_blocked',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function messages(){
        return $this->hasMany(Message::class);
    }
    public function setPasswordAttribute($password){
        $this->attributes['password'] = Hash::make($password);
    }
    public function sendEmailVerificationNotification()
    {
        $this->notify(new SendVerify());
    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
