<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Group::class);
    }

    public function canAffectTask(Task $task)
    {
        return $this->tasks->contains($task);
    }
}
