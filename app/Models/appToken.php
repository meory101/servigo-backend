<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appToken extends Model
{
    use HasFactory;
    protected $table = 'application_token';
    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }
}
