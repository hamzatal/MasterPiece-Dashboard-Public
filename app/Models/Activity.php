<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'description',
        'type'
    ];

    protected $attributes = [
        'description' => 'No description available'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Deleted User'
        ]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class)->withDefault();
    }
}
