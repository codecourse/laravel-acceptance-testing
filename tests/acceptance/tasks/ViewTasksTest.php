<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewTasksTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_see_all_tasks_on_dashboard()
    {
        $user = factory(\App\User::class)->create();
        $groups = factory(\App\Group::class, 5)->create(['user_id' => $user->id]);

        $createdTasks = collect();

        foreach ($groups as $group) {
            $createdTasks->push(factory(\App\Task::class)->create(['group_id' => $group->id]));
        }

        $this->actingAs($user)
            ->visit('/home');

        $createdTasks->each(function ($task) {
            $this->see($task->title)
                ->see('(' . $task->group->title . ')');
        });
    }
}
