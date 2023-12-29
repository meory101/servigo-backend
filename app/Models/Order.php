<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';

    public function seller()
    {
        return $this->belongsTo(User::class, 'sellerid', 'id');
    }
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyerid', 'id');
    }
    public function mediator()
    {
        return $this->belongsTo(User::class, 'mediatorid', 'id');
    }
    public function document()
    {
        return $this->hasMany(Document::class, 'id', 'orderid');
    }
    public function pfile()
    {
        return $this->hasOne(ProjectFiles::class, 'id', 'orderid');
    }
}
