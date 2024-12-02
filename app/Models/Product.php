<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'discount',
        'category_id',
        'stock_quantity',
        'description',
        'image_path'
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
        return $this->hasMany(Discount::class);
    }
    public function scopeTopSelling($query, $limit = 1)
    {
        return $query->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->limit($limit);
    }
}
