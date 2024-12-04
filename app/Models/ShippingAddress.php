<?php
// app/Models/ShippingAddress.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    // Specify the table name (if it differs from the default plural form)
    protected $table = 'shipping_addresses';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'address_type',
        'street_address',
        'city',
        'state',
        'zip_code',
        'country',
        'default_address',
    ];

    // Define the inverse relationship with the Order model
    public function order()
    {
        return $this->belongsTo(Order::class);  // A shipping address belongs to one order
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);  // A shipping address belongs to one user
    }
}
