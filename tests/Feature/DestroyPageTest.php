<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DestroyPageTest extends TestCase
{ 
    use RefreshDatabase;

    /** @test */
    function an_auth_user_can_permenantly_delete_a_page() {

        DB::statement('PRAGMA foreign_keys=on;');

        $this->signIn();

        $page = factory('App\Page', null)->states('trashed')->create();
        $page->contents()->save( make('App\Content') );

        $page->slug = "new-slug";

        $page->save();

        $redirect = create("App\Redirect", ["source_url" => $page->slug, "redirect_url" => $page->fresh()->slug]);

        $this->assertDatabaseHas('redirects', ['source_url' => $page->slug]);
        $this->assertDatabaseHas('revisions', ['content_id' => $page->contents->first()->id]);

        $this->get( route('trash.destroy', $page ) )
            ->assertStatus(302)
            ->assertRedirect( route('trash.index') );

        $this->assertDatabaseMissing('pages', ['id'=> $page->id]);
        $this->assertDatabaseMissing('redirects', ['source_url'=> $page->slug]);
      
    }
}
