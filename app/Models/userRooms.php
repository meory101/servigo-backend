<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userRooms extends Model
{
    use HasFactory;
    protected $table = 'userrooms';

    public function user1()
    {
        return $this->belongsTo(User::class, 'userid1', 'id');
    }
    public function user2()
    {
        return $this->belongsTo(User::class, 'userid2', 'id');
    }
    public function room()
    {
        return $this->belongsTo(Room::class, 'roomid', 'id');
    }
    public function message()
    {
        return $this->hasMany(Message::class, 'id', 'roomid');
    }
}
