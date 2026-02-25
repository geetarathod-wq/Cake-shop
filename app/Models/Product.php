<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
    'name',
    'slug',
    'description',
    'egg_type',
    'price',
    'category_id',
    'image',
    'is_active',
    'is_featured'
];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}