<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WalkInOrder;
class WalkInOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'walk_in_order_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(WalkInOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}