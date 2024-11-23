<?php
namespace App\Observers;

use App\Models\Task;
use App\Models\Activity;

class TaskObserver
{
    public function created(Task $task)
    {
        Activity::create([
            'user_id' => auth()->id() ?? $task->user_id,
            'type' => 'task_created',
            'description' => "New task '{$task->title}' was created",
            'subject_type' => Task::class,
            'subject_id' => $task->id
        ]);
    }

    public function updated(Task $task)
    {
        if ($task->isDirty('status')) {
            Activity::create([
                'user_id' => auth()->id() ?? $task->user_id,
                'type' => 'task_status_changed',
                'description' => "Task '{$task->title}' status changed to {$task->status}",
                'subject_type' => Task::class,
                'subject_id' => $task->id
            ]);
        }
    }

    public function deleted(Task $task)
    {
        Activity::create([
            'user_id' => auth()->id() ?? $task->user_id,
            'type' => 'task_deleted',
            'description' => "Task '{$task->title}' was deleted",
            'subject_type' => Task::class,
            'subject_id' => $task->id
        ]);
    }
}
