<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectFiles extends Model
{
    use HasFactory;
    protected $table = 'project_files';

    public function order(){
        return $this->belongsTo(Order::class,'orderid','id');
    }
}
