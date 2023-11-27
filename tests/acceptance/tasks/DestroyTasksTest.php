<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DestroyTasksTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_destroy_a_task()
    {
        list($user, $group, $task) = $this->createTaskWithGroupAndUser();

        $this->actingAs($user)
            ->visit('/groups/' . $group->id)
            ->press('destroy-task-' . $task->id);

        $this->see('Task deleted successfully')
            ->dontSee($task->title)
            ->dontSeeInDatabase('tasks', [
                'title' => $task->title,
            ]);
    }

    /** @test */
    public function user_cannot_destroy_another_users_task()
    {
        $user = factory(\App\User::class)->create();

        $anotherUser = factory(\App\User::class)->create();
        $inaccessibleGroup = factory(\App\Group::class)->create(['user_id' => $anotherUser->id]);

        $task = factory(\App\Task::class)->create(['group_id' => $inaccessibleGroup->id]);

        $this->actingAs($user)->call('delete', '/groups/' . $inaccessibleGroup->id . '/tasks/' . $task->id);

        $this->assertResponseStatus(403);
    }
}
