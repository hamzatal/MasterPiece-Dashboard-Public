<?php
namespace App\Observers;

use App\Models\User;
use App\Models\Activity;

class UserObserver
{
    public function created(User $user)
    {
        Activity::create([
            'user_id' => $user->id,
            'type' => 'user_registered',
            'description' => "New user {$user->name} joined",
            'subject_type' => User::class,
            'subject_id' => $user->id
        ]);
    }

    public function deleted(User $user)
    {
        Activity::create([
            'user_id' => auth()->id() ?? $user->id,
            'type' => 'user_deleted',
            'description' => "User {$user->name} was deleted",
            'subject_type' => User::class,
            'subject_id' => $user->id
        ]);
    }
}
