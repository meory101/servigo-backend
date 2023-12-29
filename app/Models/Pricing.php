<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;
    protected $table ='pricing';

    public function subcategory()
    {
        return $this->belongsTo(subCategory::class, 'subcategoryid', 'id');
    }
    public function profile()
    {
        return $this->belongsTo(profile::class, 'profileid', 'id');
    }
}
