<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditPageTest extends TestCase
{
    
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_not_edit_a_page()
    {
        $this->withExceptionHandling();

        $page = make("App\Page");

        $this->get("/page/{$page->slug}/edit")
            ->assertRedirect('/login');

        $this->patch("/page/update/{$page->slug}")
            ->assertRedirect('/login');

    }

    /** @test */
    public function an_authenticated_user_can_see_edit_page()
    {
        $this->signIn();

        $page = create("App\Page");
        $page->contents()->save(make('App\Content'));

        $this->get("/page/{$page->slug}/edit")
            ->assertStatus(200);
    }

    /** @test */
    public function an_authenticated_user_can_edit_pages()
    {
        $return = $this->editPage();
        $return['response']->assertRedirect($return['slug']);   
    }

    /** @test */
    public function an_edit_page_requires_a_title()
    {
        $return = $this->editPage([],['title' => null]);
        $return['response']->assertSessionHasErrors('title');
    }

    /** @test */
    public function an_edit_page_slug_can_have_spaces()
    {
        $return = $this->editPage(['slug' => "this is a spaced out slug"]);
        $return['response']->assertRedirect($return['slug']);
    }

    /** @test */
    public function an_edit_page_slug_can_have_spaces_but_must_still_be_unique()
    {

        $this->withExceptionHandling()->signIn();

        $firstPage = create("App\Page");
        $firstPage->contents()->save(make('App\Content'));

        $secondPage = create("App\Page");
        $secondPage->contents()->save(make('App\Content'));

        $this->patch("/page/update/{$firstPage->slug}", [
                'title' => 'blah',
                'slug' => str_replace('-', ' ', $secondPage->slug),
                'lang' => 'en',
                'meta_description' => 'blah',
                'meta_robot' => '',
            ])
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function page_must_exist_to_edit_it()
    {   
        $this->withExceptionHandling()->signIn();

        $this->get("/page/doesnt-exist/edit")
            ->assertStatus(404);
    }

    /** @test */
    public function an_edit_page_requires_a_slug()
    {
        $return = $this->editPage(['slug' => null]);
        $return['response']->assertSessionHasErrors('slug');
    }

    /** @test */
    public function an_edit_page_requires_a_meta_description()
    {
        $return = $this->editPage([],['meta_description' => null]);
        $return['response']->assertSessionHasErrors('meta_description');
    }

    /** @test */
    public function an_edit_page_requires_a_unique_slug()
    {
        
        $this->withExceptionHandling()->signIn();

        $firstPage = create("App\Page");
        $firstPage->contents()->save(make('App\Content'));

        $secondPage = create("App\Page");
        $secondPage->contents()->save(make('App\Content'));

        $this->patch("/page/update/{$firstPage->slug}", [
                'title' => 'blah',
                'slug' => $secondPage->slug,
                'lang' => 'en',
                'meta_description' => 'blah',
                'meta_robot' => '',
            ])
            ->assertSessionHasErrors('slug');

    }


    /** @test */
    public function updating_a_non_existent_page_must_throw_exception()
    {   
        $this->withExceptionHandling()->signIn();

        $this->patch("/page/update/non-existent-page", [
                'title' => 'blah',
                'slug' => 'non-existent-page',
                'lang' => 'en',
                'meta_description' => 'blah',
                'meta_robot' => '',
            ])->assertStatus(404);
    }

    private function editPage($page_overrides=[],$content_overrides=[])
    {
        $this->withExceptionHandling()->signIn();

        //create a new page and content and persist it
        $page = create("App\Page");
        $page->contents()->save(make('App\Content'));

        //make some new content
        $newPage = make('App\Page',$page_overrides);
        $newContents = make('App\Content',$content_overrides);
        return [
            "slug" => str_slug($newPage->slug), 
            "response" => $this->patch("/page/update/{$page->slug}", [
                'title' => $newContents->title,
                'slug' => $newPage->slug,
                'lang' => $newContents->lang,
                'meta_description' => $newContents->meta_description,
                'meta_robot' => $newContents->meta_robot,
            ]),
        ];
    }
}
