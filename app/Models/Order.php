<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total',
        'status',
        'product_id',
        'amount',
        'status'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // Relationship for customer (user)
    public function customer_details()
    {
        return $this->belongsTo(Customer::class, 'customer_id'); // Adjust based on your database schema
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship for order items (assuming you have an OrderItem model)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
