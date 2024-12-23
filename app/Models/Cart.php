<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 'carts';

    // Fillable attributes
    protected $fillable = [
        'user_id',
        'product_id',
        // Add any other necessary fields
    ];

    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
