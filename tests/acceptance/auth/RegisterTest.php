<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function test_user_can_register()
    {
        $this->visit('/register')
            ->type('Alex Garrett', 'name')
            ->type('alex@testing.com', 'email')
            ->type('ilovecats', 'password')
            ->type('ilovecats', 'password_confirmation')
            ->press('Register');

        $this->seePageIs('/home')
            ->seeInDatabase('users', [
                'name' => 'Alex Garrett',
                'email' => 'alex@testing.com'
            ]);
    }
}
