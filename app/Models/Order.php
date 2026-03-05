<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
    'user_id',
    'name',
    'email',
    'phone',
    'address',
    'delivery_date',
    'total_amount',
    'status'
    ];

    /**
     * Relationship: One order has many items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}