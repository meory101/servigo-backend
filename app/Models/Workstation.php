<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workstation extends Model
{
    use HasFactory;
    protected $table = 'workstation';
    public function subcategory(){
        return $this->belongsTo(subCategory::class,'subcategoryid','id');
    }
}
