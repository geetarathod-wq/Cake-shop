<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'weight'
    ];

    // Optional: Link back to the product to get the name/image later
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}