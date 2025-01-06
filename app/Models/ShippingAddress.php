<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'address_type',
        'street_address',
        'city',
        'country',
        'default_address',
    ];

    protected $casts = [
        'default_address' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function getFullAddressAttribute()
    {
        return "{$this->street_address}, {$this->city}, {$this->country}";
    }
}
