<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // Define the table name if it's not following Laravel's convention of pluralization
    // protected $table = 'tasks'; // Uncomment if necessary

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'title', 'description', 'status', 'user_id', 'project_id', // Add your task fields here
    ];

    // Define relationships if needed (e.g., a Task belongs to a Project, User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A task belongs to a project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
