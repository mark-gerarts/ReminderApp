<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomePageTest extends TestCase
{
    public function testItDisplaysPage()
    {
        $this->visit('/')
             ->see('Set up text message reminders.');
    }

    public function testLinks()
    {
        //Contact link
        $this->visit('/')
            ->click('Contact')
            ->seePageIs('/contact');

        //Contact link
        $this->visit('/')
            ->click('Pricing')
            ->seePageIs('/pricing');
    }
}
