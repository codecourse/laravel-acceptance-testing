<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewGroupTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_see_groups_in_list()
    {
        $user = factory(\App\User::class)->create();
        $groups = factory(\App\Group::class, 5)->make();

        $user->groups()->saveMany($groups);

        $this->actingAs($user)
            ->visit('/home');

        $groups->each(function ($group) {
            $this->see($group->title);
        });
    }

    /** @test */
    public function user_can_view_tasks_in_a_group()
    {
        // Arrange
        $user = factory(\App\User::class)->create();
        $group = factory(\App\Group::class)->make();
        $tasks = factory(\App\Task::class, 10)->make();

        $user->groups()->save($group);
        $group->tasks()->saveMany($tasks);

        // Act
        $this->actingAs($user)
            ->visit('/groups/' . $group->id);

        // Assert
        $this->see($group->title);

        $tasks->each(function ($task) {
            $this->see($task->title);
        });
    }

    /** @test */
    public function user_cannot_see_group_they_do_not_own()
    {
        $user = factory(\App\User::class)->create();

        $anotherUser = factory(\App\User::class)->create();
        $inaccessibleGroup = factory(\App\Group::class)->create(['user_id' => $anotherUser->id]);

        $this->actingAs($user)
            ->get('/groups/' . $inaccessibleGroup->id);

        $this->assertResponseStatus(403);
    }
}
