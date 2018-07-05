<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowHomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_the_homepage()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }


    /** @test */
    public function the_homepage_has_the_default_title_and_a_meta_description()
    {   
        $title = config('settings.company');
        $meta_description = config('settings.meta_description');

        $this->get("/")
          ->assertSee('<title>' . $title . '</title>')
          ->assertSee('<meta name="description" content="' . $meta_description . '" />')
          ->assertStatus(200);
    }

   


}
