<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'message',
        'type',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getStatusClass(): string
    {
        return match($this->type) {
            'warning' => 'bg-yellow-500',
            'error' => 'bg-red-500',
            'success' => 'bg-green-500',
            default => 'bg-blue-500',
        };
    }
}
