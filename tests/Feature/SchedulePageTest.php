<?php
namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class SchedulePageTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    function a_page_not_scheduled_is_still_visible() 
    {
    
        $this->withExceptionHandling();

        $page = create('App\Page');

        $page->contents()
            ->save( make('App\Content') );

        $this->get('/' . $page->slug )
            ->assertStatus(200);

    }

    /** @test */
    function a_page_can_be_published_and_unpublished() 
    {
        
        $this->withExceptionHandling();

        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth()->startOfDay();
        $nextMonth = $now->copy()->addMonth()->endOfDay();
       
        $this->signIn();

        $page = create(
            'App\Page', 
            [
                "publish_at" => $now,
                "unpublish_at" => $nextMonth,
            ],
            null,
            'scheduled');

        $page->contents()->save( make('App\Content') );

        Carbon::setTestNow( $lastMonth );
        
        $this->get('/' . $page->slug )
            ->assertStatus(404);
        
        Carbon::setTestNow( $now );
        
        $this->get('/' . $page->slug )
            ->assertStatus(200);

        Carbon::setTestNow( $nextMonth->addSecond() );

        $this->get('/' . $page->slug )
            ->assertStatus(404);

    }

    /** @test */
    function publish_date_cannot_be_greater_than_unpublish_date() 
    {
    
        $this->withExceptionHandling();

        $this->signIn();

        $now = Carbon::now();
        $nextMonth = $now->copy()->addMonth()->endOfDay();

        $page = create('App\Page');

        $this->patch("/page/update/{$page->slug}", [
            "publish_at" => $nextMonth,
            "unpublish_at" => $now,
        ])->assertSessionHasErrors('unpublish_at');

    }

    /** @test */
    function publish_date_can_be_equal_to_the_unpublish_date() 
    {
    
        $this->signIn();

        $now = Carbon::now();

        $page = create('App\Page');
        $content = $page->contents()->save( make('App\Content') );

        $this->patch("/page/update/{$page->slug}", [
            "title" => "something",
            "slug" => $page->slug,
            "meta_description" => "something",
            "publish_at" => $now->toDateString(),
            "unpublish_at" => $now->toDateString(),
        ])->assertRedirect($page->slug);

    }

    /** @test */
    function publish_date_can_be_filled_and_the_unpublish_date_can_be_null() 
    {
    
        $this->signIn();

        $now = Carbon::now();

        $page = create('App\Page');
        $content = $page->contents()->save( make('App\Content') );

        $this->patch("/page/update/{$page->slug}", [
            "title" => "something",
            "slug" => $page->slug,
            "meta_description" => "something",
            "publish_at" => $now->toDateString(),
            "unpublish_at" => null,
        ])->assertRedirect($page->slug);

    }

    /** @test */
    function unpublish_date_can_be_filled_and_the_publish_date_can_be_null() 
    {
    
        $this->signIn();

        $now = Carbon::now();

        $page = create('App\Page');

        $content = $page->contents()->save( make('App\Content') );

        $this->patch("/page/update/{$page->slug}", [
            "title" => "something",
            "slug" => $page->slug,
            "meta_description" => "something",
            "publish_at" => null,
            "unpublish_at" => $now->toDateString(),
        ])->assertRedirect($page->slug);

    }

    /** @test */
    function submitting_null_values_updates_the_database() 
    {

        $this->signIn();

        $now = Carbon::now();

        $page = create('App\Page', [], null, 'scheduled');
        $page->contents()->save( make('App\Content') );

        $this->assertDatabaseHas('pages', [
            'slug' => $page->slug,
            'publish_at' => $page->publish_at,
            'unpublish_at' => $page->unpublish_at,
        ]);

        $this->patch("/page/update/{$page->slug}", [
            "title" => "something",
            "slug" => $page->slug,
            "meta_description" => "something",
            "publish_at" => NULL,
            "unpublish_at" => NULL,
        ])->assertRedirect($page->slug);

        $this->assertDatabaseHas('pages', [
            'slug' => $page->slug,
            'publish_at' => NULL,
            'unpublish_at' => NULL,
        ]);

    }

    /** @test */
    function page_form_should_show_schedule_fields() 
    {

        $this->signIn();

        $now = Carbon::now();

        $publish_at     = $now->copy()->subDay()->toDateString();
        $unpublish_at   = $now->copy()->addDay()->toDateString();

        $page = create('App\Page', [
            'publish_at' => $publish_at,
            'unpublish_at' => $unpublish_at,
        ], null, 'scheduled');

        $page->contents()->save( make('App\Content') );

        $this->get("/page/{$page->slug}/edit")
            ->assertStatus(200)
            ->assertSee($publish_at)
            ->assertSee($unpublish_at);

    }


}
