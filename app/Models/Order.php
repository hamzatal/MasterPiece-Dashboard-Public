<?php

namespace App\Models;

use Faker\Provider\ar_EG\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total',
        'payment_id',
        'payment_status',
    ];
    protected $casts = [
        'total' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    // Default values
    protected $attributes = [
        'status' => 'pending',
        'payment_method' => 'credit_card',
    ];
    // Relationships
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function orderItems()
    {
        return $this->belongsToMany(Product::class, 'order_items')->withPivot('quantity', 'price');
    }
    public function shippingAddress()
    {
        return $this->hasOne(ShippingAddress::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total, 2);
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
    // Events
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->status = $order->status ?? 'pending';
        });
    }
}
