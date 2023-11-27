<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function test_user_can_login()
    {
        $user = factory(\App\User::class)->create(['email' => 'alex@testing.com']);

        $this->visit('/login')
            ->type('alex@testing.com', 'email')
            ->type('secret', 'password')
            ->press('Login');

        $this->assertEquals('alex@testing.com', Auth::user()->email);
    }
}
