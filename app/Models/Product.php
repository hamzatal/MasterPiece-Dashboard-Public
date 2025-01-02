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
        'image1',
        'image2',
        'image3',
        'new_price',
        'original_price',
        'stock_quantity',
        'size',
        'color',
        'rating',
        'category_id',
        'status',
        'is_on_sale',
        'discount_percentage',
        'is_discount_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOnSale($query)
    {
        return $query->where('is_on_sale', 1);
    }

    public function getImagesAttribute()
    {
        return array_filter([
            $this->image1,
            $this->image2,
            $this->image3,
        ]);
    }

    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating, 1);
    }

    public function getIsDiscountedAttribute()
    {
        return $this->is_discount_active && $this->discount_percentage > 0;
    }
}
