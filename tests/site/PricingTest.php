<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PricingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItDisplaysPage()
    {
        $this->visit('/pricing')
            ->see('Pricing');
    }
}
