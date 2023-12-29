<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mainCategory extends Model
{
    use HasFactory;
    protected $table = 'maincategory';
    public function servicetype(){
        return $this->belongsTo(serviceType::class,'servicetypeid','id');
    }
    public function subcategory()
    {
        return $this->hasMany(subcategory::class, 'id', 'subcategoryid');
    }
}
