<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subCategory extends Model
{
    use HasFactory;
    protected $table = 'subcategory';
    public function maincategory(){
        return $this->belongsTo(mainCategory::class,'maincategoryid','id');
    }
    public function profile(){
     return   $this->hasMany(Profile::class,'pricing','subcategoryid','profileid');
    }
    public function pricing()
    {
        return $this->hasMany(Pricing::class, 'id', 'subcateoryid');
    }
    public function workstation()
    {
        return $this->hasMany(Workstation::class, 'id', 'subcategoryid');
    }
    public function post()
    {
        return $this->hasMany(Post::class, 'id', 'subcategory');
    }
}
