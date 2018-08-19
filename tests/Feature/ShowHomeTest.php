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


    /** @test */
    public function a_page_that_is_set_as_home_must_redirect()
    {

        $page = create('App\Page');
        $page->contents()->save(make('App\Content'));

        config(['settings.front' => $page->slug]);

        $response = $this->get($page->slug);
        $response->assertRedirect('/');
    }

    /** @test */
    public function if_the_front_setting_is_not_null_the_homepage_will_display_the_page()
    {

        $content = create('App\Content');

        config(['settings.front' => $content->page->slug]);

        $this->get('/')->assertSee('<title>' . $content->title);
    }

    /** @test */
    public function if_the_front_setting_is_null_and_no_pages_exist_the_homepage_will_display_a_default_message()
    {
        config(['settings.front' => null]);

        $response = $this->get('/');

        $response->assertSee('Add some content');

    }

    /** @test */
    public function if_the_front_setting_is_null_the_homepage_will_display_a_list()
    {

        $contents = create('App\Content',[],10);

        config(['settings.front' => null]);

        $response = $this->get('/');

        foreach($contents AS $content)
        {
            $response->assertSee($content->title);
        }
        
    }

    /** @test */
    public function if_the_front_setting_is_not_a_page_the_homepage_will_display_page_not_found()
    {
        $this->withExceptionHandling();

        $contents = create('App\Content',[],10);

        config(['settings.front' => 'nonexiststent_page']);

        $response = $this->get('/');
        $response->assertstatus(404);
    }

    

}
