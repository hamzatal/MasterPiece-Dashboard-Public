<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Activity;

class ProjectObserver
{
    public function created(Project $project)
    {
        Activity::create([
            'user_id' => auth()->id() ?? $project->user_id,
            'type' => 'project_created',
            'description' => "New project '{$project->name}' was created",
            'subject_type' => Project::class,
            'subject_id' => $project->id
        ]);
    }

    public function updated(Project $project)
    {
        if ($project->isDirty('status')) {
            Activity::create([
                'user_id' => auth()->id() ?? $project->user_id,
                'type' => 'project_status_changed',
                'description' => "Project '{$project->name}' status changed to {$project->status}",
                'subject_type' => Project::class,
                'subject_id' => $project->id
            ]);
        }
    }

    public function deleted(Project $project)
    {
        Activity::create([
            'user_id' => auth()->id() ?? $project->user_id,
            'type' => 'project_deleted',
            'description' => "Project '{$project->name}' was deleted",
            'subject_type' => Project::class,
            'subject_id' => $project->id
        ]);
    }
}
