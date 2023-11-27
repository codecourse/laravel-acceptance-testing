<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateTasksTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_create_a_task()
    {
        $user = factory(\App\User::class)->create();
        $group = factory(\App\Group::class)->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->visit('/groups/' . $group->id)
            ->type('Pick up soya milk', 'task_title')
            ->press('create-task');

        $this->see('Task created successfully')
            ->see('Pick up soya milk')
            ->seeInDatabase('tasks', [
                'title' => 'Pick up soya milk',
            ]);
    }

    /** @test */
    public function user_cant_create_a_task_without_a_title()
    {
        $user = factory(\App\User::class)->create();
        $group = factory(\App\Group::class)->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->visit('/groups/' . $group->id)
            ->type('', 'task_title')
            ->press('create-task');

        $this->see('Please enter a task title.')
            ->dontSeeInDatabase('tasks', [
                'title' => ''
            ]);
    }

    /** @test */
    public function user_cant_create_a_task_in_another_users_group()
    {
        $user = factory(\App\User::class)->create();

        $anotherUser = factory(\App\User::class)->create();
        $inaccessibleGroup = factory(\App\Group::class)->create(['user_id' => $anotherUser->id]);

        $this->actingAs($user)->post('/groups/' . $inaccessibleGroup->id . '/tasks', [
            'task_title' => 'Pick up eggs',
        ]);

        $this->assertResponseStatus(403);
    }
}
