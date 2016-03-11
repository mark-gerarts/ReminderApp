<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItDisplaysPage()
    {
        $this->visit('/login')
            ->see('Sign in');
    }

    public function testLinks()
    {
        $this->visit('/login')
            ->click('Register here.')
            ->seePageIs('/register');
    }

    public function testFormSubmitGoodData()
    {
        // Create a user.
        $user = factory(App\Models\User::class)->make([
            "name" => "TestName",
            "email" => "test@email.com",
            "password" => bcrypt("hunter2")
        ]);
        // Test a good form submission
        $this->visit('/login')
            ->type("test@email.com", 'email')
            ->type("hunter2", 'password')
            ->press('Log in')
            ->see('credentials');
            //->seePageIs($user->password);
     }
}
