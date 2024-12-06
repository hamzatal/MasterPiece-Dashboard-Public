<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'status'
    ];

    // Relationship with products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Scope to filter active categories
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    // Scope to filter inactive categories
    public function scopeInactive(Builder $query)
    {
        return $query->where('status', 'inactive');
    }
}
