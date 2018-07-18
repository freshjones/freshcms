<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /** @test */
    public function basic_example()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('FreshJones Creative');

            $browser->clickLink('login')
                ->assertSee('E-Mail Address');

            $browser
                ->type('email', 'admin@freshjones.com')
                ->type('password', 'blah')
                ->press('Login')
                ->assertSee('These credentials do not match our records.');



        });
    }
}
