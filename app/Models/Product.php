<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'new_price',
        'original_price',
        'stock_quantity',
        'discount_percentage',
        'is_discount_active',
        'category_id',
        'image'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    // In Product model
    public function discounts()
    {
        return $this->hasMany(Product_discount::class);
    }
    public function scopeTopSelling($query, $limit = 1)
    {
        return $query->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->limit($limit);
    }
}
