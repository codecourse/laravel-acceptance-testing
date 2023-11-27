<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateTasksTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_click_edit_button_to_see_edit_page()
    {
        list($user, $group, $task) = $this->createTaskWithGroupAndUser();

        $this->actingAs($user)
            ->visit('/groups/' . $group->id)
            ->click('update-task-' . $task->id);

        $this->seePageIs('/groups/' . $group->id . '/tasks/' . $task->id . '/edit')
            ->seeInField('task_title', $task->title)
            ->see('Editing task: ' . $task->title);
    }

    /** @test */
    public function user_can_change_title_of_task()
    {
        list($user, $group, $task) = $this->createTaskWithGroupAndUser();

        $this->actingAs($user)
            ->visit('/groups/' . $group->id . '/tasks/' . $task->id . '/edit')
            ->type('New task title', 'task_title')
            ->press('Save task');

        $this->seePageIs('/groups/' . $group->id)
            ->see('Task was updated')
            ->see('New task title')
            ->seeInDatabase('tasks', [
                'title' => 'New task title',
            ]);
    }

    /** @test */
    public function user_cant_update_task_with_empty_title()
    {
        list($user, $group, $task) = $this->createTaskWithGroupAndUser();

        $this->actingAs($user)
            ->visit('/groups/' . $group->id . '/tasks/' . $task->id . '/edit')
            ->type('', 'task_title')
            ->press('Save task');

        $this->seePageIs('/groups/' . $group->id . '/tasks/' . $task->id . '/edit')
            ->see('Task title is required.')
            ->dontSeeInDatabase('tasks', [
                'title' => '',
            ]);
    }

    /** @test */
    public function user_cant_update_another_users_task()
    {
        $user = factory(\App\User::class)->create();

        $anotherUser = factory(\App\User::class)->create();
        $inaccessibleGroup = factory(\App\Group::class)->create(['user_id' => $anotherUser->id]);

        $task = factory(\App\Task::class)->create(['group_id' => $inaccessibleGroup->id]);

        $this->actingAs($user)
            ->call('patch', '/groups/' . $inaccessibleGroup->id . '/tasks/' . $task->id, [
                'task_title' => 'Updated task title'
            ]);

        $this->assertResponseStatus(403);
    }

    /** @test */
    public function user_cant_see_update_page_for_another_users_task()
    {
        $user = factory(\App\User::class)->create();

        $anotherUser = factory(\App\User::class)->create();
        $inaccessibleGroup = factory(\App\Group::class)->create(['user_id' => $anotherUser->id]);

        $task = factory(\App\Task::class)->create(['group_id' => $inaccessibleGroup->id]);

        $this->actingAs($user)
            ->call('get', '/groups/' . $inaccessibleGroup->id . '/tasks/' . $task->id . '/edit');

        $this->assertResponseStatus(403);
    }
}
