<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'total',
        'payment_status',
        'name',
        'price',
        'status',
        'payment_method',
        'amount',
        'total_price',
        'total_amount',
        'coupon_id',
        'shipping_address_id',

    ];

    // Add payment enum values as constants
    const PAYMENT_PAYPAL = 'paypal';
    const PAYMENT_VISA = 'visa';
    const PAYMENT_CASH = 'cash';

    // Add payment status enum values as constants
    const STATUS_PAID = 'paid';
    const STATUS_PENDING = 'pending';
    const STATUS_FAILED = 'failed';

    protected $casts = [
        'total' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'pending',
        'payment_method' => 'credit_card',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function orderItems()
    {
        return $this->belongsToMany(Product::class, 'order_items')->withPivot('quantity', 'price', 'size', 'color');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'processing' => 'blue',
            'shipped' => 'teal',
            'delivered' => 'green',
            'cancelled' => 'red',
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function getFormattedTotalAttribute()
    {
        return 'JD ' . number_format($this->total, 2);
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            $order->status = $order->status ?? 'pending';
        });
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
