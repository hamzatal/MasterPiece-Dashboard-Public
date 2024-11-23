<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_name',
        'quantity',
        'price',
        'total',
    ];

    // Define the relationship between OrderItem and Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
