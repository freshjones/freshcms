<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowHeaderTest extends TestCase
{   
    use RefreshDatabase;

    /** @test */
    public function the_header_shows_the_company_name()
    {
        $companyName = config('settings.company');

        $this->get("/")
            ->assertSee('<h5 class="company-name navbar-brand m-0 p-0">' . $companyName . '</h5>');
    }

    /** @test */
    public function the_header_shows_the_tagline_if_available()
    {
        $tagline = config('settings.tagline');
        
        $this->get("/")
            ->assertSee('<span class="tagline navbar-text mr-auto px-2 d-none d-lg-block">' . $tagline . '</span>');
    }

    /** @test */
    public function the_header_does_not_show_the_tagline_if_empty()
    {
        config(['settings.tagline' => '']);
        $tagline = config('settings.tagline');

        $this->get("/")
            ->assertDontSee('<span class="tagline navbar-text mr-auto px-2 d-none d-lg-block">');
    }


}
