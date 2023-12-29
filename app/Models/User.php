<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'users';
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'userid');
    }
    public function rate()
    {
        return $this->hasMany(Rate::class, 'id', 'userid');
    }
    public function order1()
    {
        return $this->hasMany(Order::class, 'id', 'sellerid');
    }
    public function order2()
    {
        return $this->hasMany(Order::class, 'id', 'buyerid');
    }
    public function order3()
    {
        return $this->hasMany(Order::class, 'id', 'mediatorid');
    }
    public function userroom1()
    {
        return $this->hasMany(userRooms::class, 'id', 'userid1');
    }
    public function userroom2()
    {
        return $this->hasMany(userRooms::class, 'id', 'userid2');
    }
    public function apptokens()
    {
        return $this->hasMany(appToken::class, 'id', 'userid');
    }
}
