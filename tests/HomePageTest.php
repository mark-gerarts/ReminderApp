<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomePageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItDisplaysPage()
    {
        $this->visit('/')
             ->see('Set up text message reminders.');
    }
    public function testLinks()
    {
        $this->visit('/')
             ->click('Sign in')
             ->seePageIs('/login');
    }
}
