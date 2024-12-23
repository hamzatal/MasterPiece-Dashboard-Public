<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'discount_percentage',
        'start_date',
        'end_date',
        'is_active'
    ];

    // Relationship with Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes for active and inactive discounts
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function isExpired()
    {
        return $this->enddate < now();
    }

    public function calculateDiscountedPrice()
    {
        return $this->product->price - ($this->product->price * ($this->percentage / 100));
    }
}
