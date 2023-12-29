<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class postImage extends Model
{
    use HasFactory;
    protected $table = 'postimage';
    public function post(){
        return $this->belongsTo(Post::class,'postid','id');
    }
}
