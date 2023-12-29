<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
   protected $table  = 'attachment';
    public function document()
    {
        return $this->belongsTo(Document::class,  'documentid', 'id');
    }
}
