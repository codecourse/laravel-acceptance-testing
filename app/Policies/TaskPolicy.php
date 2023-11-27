<?php

namespace App\Policies;

use App\User;
use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function affect(User $user, Task $task)
    {
        return $user->canAffectTask($task);
    }
}
