<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'image',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // User.php model
    public function orders()
    {
        return $this->hasMany(Order::class, 'id');
    }

    public function setProfileImageAttribute($value)
    {
        if ($value) {
            // Store the image in 'profile_images' directory and return the public path
            $path = $value->store('profile_images', 'public');
            $this->attributes['image'] = '/storage/' . $path; // Store the path with '/storage/'
        }
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function isAdmin()
    {
        return $this->role === 'admin'; // Adjust this condition based on how roles are stored in your system.
    }
    public function shippingAddresses()
{
    return $this->hasMany(ShippingAddress::class, 'user_id');
}
}
