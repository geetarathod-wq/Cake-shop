<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalkInOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone',
        'email',
        'address',
        'order_date',
        'delivery_date',
        'delivery_slot',
        'order_type',
        'admin_note',
        'payment_method',
        'payment_status',
        'subtotal',
    ];

    protected $casts = [
        'order_date' => 'date',
        'delivery_date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(WalkInOrderItem::class);
    }
}