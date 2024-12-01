<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Total spend for the customer
    public function getTotalSpendAttribute()
    {
        return $this->orders()->sum('total_price');
    }

    // Number of orders
    public function getOrderCountAttribute()
    {
        return $this->orders()->count();
    }
}
