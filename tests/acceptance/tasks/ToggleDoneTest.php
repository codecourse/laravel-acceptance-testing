<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ToggleDoneTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_mark_task_as_done()
    {
        $user = factory(\App\User::class)->create();
        $group = factory(\App\Group::class)->create(['user_id' => $user->id]);
        $task = factory(\App\Task::class)->make(['done' => false]);

        $group->tasks()->save($task);

        $this->actingAs($user)
            ->visit('/groups/' . $group->id)
            ->press('toggle-task-' . $task->id);

        $this->see('Task marked as done')
            ->seeInDatabase('tasks', [
                'title' => $task->title,
                'done' => true
            ]);
    }

    /** @test */
    public function user_can_mark_task_as_to_do()
    {
        $user = factory(\App\User::class)->create();
        $group = factory(\App\Group::class)->create(['user_id' => $user->id]);
        $task = factory(\App\Task::class)->make(['done' => true]);

        $group->tasks()->save($task);

        $this->actingAs($user)
            ->visit('/groups/' . $group->id)
            ->press('toggle-task-' . $task->id);

        $this->see('Task marked as to do')
            ->seeInDatabase('tasks', [
                'title' => $task->title,
                'done' => false
            ]);
    }

    /** @test */
    public function user_cant_toggle_another_users_task()
    {
        $user = factory(\App\User::class)->create();

        $anotherUser = factory(\App\User::class)->create();
        $inaccessibleGroup = factory(\App\Group::class)->create(['user_id' => $anotherUser->id]);

        $task = factory(\App\Task::class)->create(['group_id' => $inaccessibleGroup->id, 'done' => false]);

        $this->actingAs($user)
            ->call('patch', '/groups/' . $inaccessibleGroup->id . '/tasks/' . $task->id . '/toggle');

        $this->assertResponseStatus(403);
    }
}
