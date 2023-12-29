<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'post';
    public function subcategory (){
        return $this->belongsTo(subCategory::class,'subcategoryid','id');
    }
    public function profile()
    {
        return $this->belongsTo(profile::class, 'profileid', 'id');
    }
    public function postimage(){
         return $this->hasMany(postImage::class,'id','id');
}
}
