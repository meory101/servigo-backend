<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\subCategory;



class Profile extends Model
{
    use HasFactory;
  protected  $table = 'profile' ;


  public function user(){
    return $this->belongsTo(User::class,'userid','id');
  }
  public function subcategory()
  {
   return $this->belongsToMany(subCategory::class, 'pricing', 'profileid', 'subcategoryid');
  }

public function rate(){
  return $this-> belongsTo(Rate::class,'id','profileid');
}
  public function pricing()
  {
    return $this->hasMany(pricing::class, 'profileid', 'id');
  } public function post()
  {
    return $this->hasMany(Post::class, 'id', 'profileid');
  }

}
