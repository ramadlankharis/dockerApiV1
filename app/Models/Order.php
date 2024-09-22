<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function dataJual()
    {
        return $this->belongsTo(Product::class, 'product_id');
        // return $this->belongsTo(Product::class, 'product_id')->select(['id', 'stock', 'sold']);
    }

}
