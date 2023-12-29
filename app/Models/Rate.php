<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $table = 'rate';

 
    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }
    public function profile(){
        return $this->belongsTo(Profile::class,'profileid','id');
    }
}
