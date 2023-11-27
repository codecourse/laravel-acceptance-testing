<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateGroupTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function test_user_can_create_group()
    {
        // Arrange
        $user = factory(\App\User::class)->create();

        // Act
        $this->actingAs($user)
            ->visit('/home')
            ->type('Shopping list', 'group_title')
            ->press('create-group');

        // Assert
        $this->see('Group created successfully')
            ->see('Shopping list')
            ->seeInDatabase('groups', [
                'title' => 'Shopping list'
            ]);
    }

    /** @test */
    public function test_user_cannot_create_empty_group_name()
    {
        $user = factory(\App\User::class)->create();

        $this->actingAs($user)
            ->visit('/home')
            ->type('', 'group_title')
            ->press('create-group');

        $this->dontSee('Group created successfully')
            ->see('Please enter a group title')
            ->dontSeeInDatabase('groups', [
                'title' => ''
            ]);
    }
}
