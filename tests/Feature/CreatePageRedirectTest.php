<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class CreatePageRedirectTest extends TestCase
{ 
    use RefreshDatabase;

    /** @test */
    function changing_a_page_url_creates_a_redirect() {

        //given we're logged in
        $this->signin();

        //and we have a page
        $content = create('App\Content');

        $oldSlug = $content->page->slug;
        $newSlug = 'new-slug';

        //when we change its url during edit
        $page = $this->json("patch", route('page-update', $oldSlug), [
            'title' => 'new title',
            'slug' => $newSlug,
            'lang' => 'en',
            'meta_description' => 'blah',
            'meta_robot' => '',
        ]);

        //we should have a record of the redirect in the database
        $this->assertDatabaseHas('redirects', [
            'source_url' => $oldSlug,
            'redirect_url' => $newSlug
        ]);

    }

    /** @test */
    function changing_a_page_url_to_a_previous_redirect_url_deletes_the_old_redirect_and_adds_a_new() {
        

        $firstSlug = 'first-slug';
        $secondSlug = 'second-slug';

        //given we're logged in
        $this->signin();

        //and we have a page
        $page = create('App\Page',['slug' => $secondSlug]);
        $page->contents()->save(make('App\Content'));

        //and we have a redirect
        $redirect = create('App\Redirect',['source_url' => $firstSlug, 'redirect_url' => $secondSlug]);

        //when we change its url back to the previous url
        $page = $this->json("patch", route('page-update', $secondSlug), [
            'title' => 'new title',
            'slug' => $firstSlug,
            'lang' => 'en',
            'meta_description' => 'blah',
            'meta_robot' => '',
        ]);

        //then we should only have one record in the DB and it should match properly
        $this->assertDatabaseMissing('redirects', [
            'source_url' => $firstSlug,
            'redirect_url' => $secondSlug
        ]);

        $this->assertDatabaseHas('redirects', [
            'source_url' => $secondSlug,
            'redirect_url' => $firstSlug
        ]);
      
    }

    /** @test */
    function redirects_should_all_have_one_hop_to_actual_page() {
            
        //given we're logged in
        $this->signin();

        //and we have a page
        $page = create('App\Page',['slug' => 'page']);
        $page->contents()->save(make('App\Content'));

        //and we have a couple of redirects
        $redirect = create('App\Redirect',['source_url' => 'page-1', 'redirect_url' => 'page']);
        $redirect = create('App\Redirect',['source_url' => 'page-2', 'redirect_url' => 'page']);
        $redirect = create('App\Redirect',['source_url' => 'page-3', 'redirect_url' => 'page']);

        //when we change its url back to the previous url
        $this->json("patch", route('page-update', 'page'), [
            'title' => 'new title',
            'slug' => 'page-4',
            'lang' => 'en',
            'meta_description' => 'blah',
            'meta_robot' => '',
        ]);

        //we should have 4 records and all should point to the actual page
        $all = \App\Redirect::all()->pluck('redirect_url');

        $this->assertEquals(4, $all->count() );
        
        $all->each(function ($item) {
            $this->assertEquals('page-4', $item );
        });

    }

}
