<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_value',
        'expiry_date',
        'is_active'
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'is_active' => 'boolean'
    ];

    // Scope for active coupons
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('expiry_date', '>', now());
    }

    // Check if coupon is valid
    public function isValid()
    {
        return $this->is_active &&
               Carbon::parse($this->expiry_date)->isFuture();
    }

    // Calculate discount
    public function calculateDiscount($orderTotal)
    {
        if (!$this->isValid() || $orderTotal < $this->min_order_value) {
            return 0;
        }

        return $this->discount_type === 'percentage'
            ? ($orderTotal * ($this->discount_value / 100))
            : $this->discount_value;
    }
}
