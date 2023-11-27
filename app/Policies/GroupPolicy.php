<?php

namespace App\Policies;

use App\User;
use App\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function affect(User $user, Group $group)
    {
        return $user->id === $group->user_id;
    }

    public function show(User $user, Group $group)
    {
        return $user->id === $group->user_id;
    }
}
