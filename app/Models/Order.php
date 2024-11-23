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
        // Add other fillable fields
    ];

    // Relationship for customer (user)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Relationship for order items (assuming you have an OrderItem model)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
