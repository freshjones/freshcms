<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class ShowPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_page_without_content_is_a_404()
    {   

        $this->withExceptionHandling();

        $page = factory('App\Page')->create();

        $this->get("/{$page->slug}")
            ->assertStatus(404);

        $this->get("/non-existent-page")
            ->assertStatus(404);

    }

    /** @test */
    public function a_guest_can_view_a_page()
    {   

        $page = factory('App\Page')->create();
        $page->contents()->save(factory('App\Content')->make());
            
        $this->get("/{$page->slug}")
            ->assertStatus(200);

    }

    /** @test */
    public function an_authenticated_user_can_view_a_page()
    {   

        $this->actingAs(factory(\App\User::class)->create());

        $page = factory('App\Page')->create();
        $page->contents()->save(factory('App\Content')->make());
            
        $this->get("/{$page->slug}")
            ->assertStatus(200);

    }

    /** @test */
    public function a_page_has_a_title_and_a_meta_description()
    {   

        $page = factory('App\Page')->create();
        $page->contents()->save(factory('App\Content')->make());
            
        $contents = $page->contents()->where('lang', 'en')->first();

        $this->get("/{$page->slug}")
            ->assertSee("<title>{$contents->title}")
            ->assertSee('<meta name="description" content="' . $contents->meta_description . '" />');

    }
 
}
