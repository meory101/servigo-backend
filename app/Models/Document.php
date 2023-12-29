<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'document';
  public function order(){
    return $this->belongsTo(Order::class, 'orderid','id');
  }
  public function attachemnt()
  {
    return $this->hasOne(Attachment::class, 'id', 'documentid');
  }
}
