<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class CreatePageTest extends TestCase
{
    
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_not_create_a_page()
    {
        $this->withExceptionHandling();

        $this->get('/page/create')
            ->assertRedirect('/login');

        $this->post('/page', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_view_create_a_page()
    {
        $this->signIn();

        $this->get('/page/create')
            ->assertStatus(200);
    }

    /** @test */
    public function an_authenticated_user_can_create_pages()
    {
        $this->signIn();

        $page = make('App\Page');
        $contents = make('App\Content');
      
        $this->post('/page', [
                'title' => $contents->title,
                'slug' => $page->slug,
                'lang' => $contents->lang,
                'meta_description' => $contents->meta_description,
                'meta_robot' => $contents->meta_robot,
            ])
            ->assertRedirect($page->slug);
    }

    /** @test */
    public function a_page_requires_a_title()
    {
        $this->publishPage([],['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_page_requires_a_slug()
    {
        $this->publishPage(['slug' => null])
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function a_page_requires_a_meta_description()
    {
        $this->publishPage([],['meta_description' => null])
            ->assertSessionHasErrors('meta_description');
    }

    private function publishPage($page_overrides=[],$content_overrides=[])
    {
        $this->withExceptionHandling()->signIn();

        $page = make('App\Page',$page_overrides);
        $contents = make('App\Content',$content_overrides);

        return $this->post('/page', [
                'title' => $contents->title,
                'slug' => $page->slug,
                'lang' => $contents->lang,
                'meta_description' => $contents->meta_description,
                'meta_robot' => $contents->meta_robot,
            ]);

    }

}
