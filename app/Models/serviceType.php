<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serviceType extends Model
{
    use HasFactory;
    protected $table = 'servicetype';
    public function maincategory(){
        return $this->hasMany(mainCategory::class,'id','servicetypeid');
    }
}
