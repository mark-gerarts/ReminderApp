<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    public function testItDisplaysPage()
    {
        $this->visit('/register')
            ->see('Sign up');
    }

    public function testLinks()
    {
        $this->visit('/register')
            ->click('Sign in here.')
            ->seePageIs('/login');
    }

    public function testFormSubmitGoodData()
    {
        // Test a good form submission
        $this->visit('/register')
            ->type('TestName', 'name')
            ->type('test@email.com', 'email')
            ->type('hunter2', 'password')
            ->type('hunter2', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/dashboard');
    }

    public function testFormSubmitBadData()
    {
        // Test missing name
        $this->visit('/register')
            ->type('', 'name')
            ->type('test@email.com', 'email')
            ->type('hunter2', 'password')
            ->type('hunter2', 'password_confirmation')
            ->press('Register')
            ->see('required');

        // Test missing email
        $this->visit('/register')
            ->type('TestName', 'name')
            ->type('', 'email')
            ->type('hunter2', 'password')
            ->type('hunter2', 'password_confirmation')
            ->press('Register')
            ->see('required');

        // Test wrong email
        $this->visit('/register')
            ->type('TestName', 'name')
            ->type('thisisnotvalid', 'email')
            ->type('hunter2', 'password')
            ->type('hunter2', 'password_confirmation')
            ->press('Register')
            ->see('must be a valid email');

        // Test missing password
        $this->visit('/register')
            ->type('TestName', 'name')
            ->type('test@email.com', 'email')
            ->type('', 'password')
            ->type('', 'password_confirmation')
            ->press('Register')
            ->see('required');

        // Test wrong password confirmation
        $this->visit('/register')
            ->type('TestName', 'name')
            ->type('test@email.com', 'email')
            ->type('hunter2', 'password')
            ->type('******', 'password_confirmation')
            ->press('Register')
            ->see('does not match');
    }
}
