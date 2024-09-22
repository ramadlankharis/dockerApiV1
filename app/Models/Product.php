<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public function details()
    // {
    //     return $this->belongsTo(DetailProduct::class, 'product_id')->select(['id', 'stock', 'sold']);
    // }
}
