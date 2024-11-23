<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    // Define which attributes are mass-assignable
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_value',
        'expiry_date',
    ];

    // Optionally, you can add additional logic, such as mutators or accessors
}
