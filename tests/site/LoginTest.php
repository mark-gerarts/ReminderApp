<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

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
        $this->_createUser();

        // Test a good form submission
        $this->visit('/login')
            ->type("test@email.com", 'email')
            ->type("hunter2", 'password')
            ->press('Log in')
            ->seePageIs('/dashboard');
    }

    public function testFormSubmitBadData()
    {
        $this->_createUser();

        // Without password
        $this->visit('/login')
            ->type("test@email.com", 'email')
            ->type("", 'password')
            ->press('Log in')
            ->see('required');

        // Without email
        $this->visit('/login')
            ->type("", 'email')
            ->type("hunter2", 'password')
            ->press('Log in')
            ->see('required');

        // Wrong password
        $this->visit('/login')
            ->type("test@email.com", 'email')
            ->type("hunter3", 'password')
            ->press('Log in')
            ->see('credentials do not match');
    }

    private function _createUser()
    {
        // Create a user.
        $user = factory(App\Models\User::class)->make([
            "name" => "TestName",
            "email" => "test@email.com",
            "password" => bcrypt("hunter2")
        ]);

        // Put it in the database
        $user->save();
    }
}
