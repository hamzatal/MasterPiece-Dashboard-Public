<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // Define the table associated with the model (if not following Laravel's naming convention)
    // protected $table = 'projects'; // Uncomment if your table name doesn't follow the plural 'projects' convention.

    // If the primary key is not 'id', specify the custom primary key
    // protected $primaryKey = 'custom_id'; // Uncomment and replace with your actual primary key column name.

    // If the primary key is not an incrementing integer, specify 'false'
    // public $incrementing = false; // Uncomment if your primary key is non-incrementing.

    // Define the fillable properties (to allow mass assignment)
    protected $fillable = [
        'name', 'description', 'start_date', 'end_date', 'status', // Add the actual columns in your project table
    ];

    // If your model has hidden attributes, you can define them like this
    // protected $hidden = ['password']; // For example, hiding sensitive data

    // If your model has custom date formats or timestamps, define them
    // protected $dates = ['start_date', 'end_date']; // If you're using Carbon dates
}
