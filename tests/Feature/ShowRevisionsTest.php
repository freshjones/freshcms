<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class ShowRevisionsTest extends TestCase
{ 
    use RefreshDatabase;

    /** @test */
    function editing_a_page_should_display_revision_info() {

        $this->signIn();
        
        $oldTitle = "First Title";
        $newTitle = "Second Title";

        $content = create('App\Content', ['title' => $oldTitle]);
        
        $content->title = $newTitle;
        $content->save();

        $this->get("/page/{$content->page->slug}/edit")
            ->assertSee($newTitle)
            ->assertSee($oldTitle);
        
        $this->assertDatabaseHas('revisions', ['title' => $newTitle]);

        $this->assertDatabaseHas('revisions', ['title' => $oldTitle]);

    }
}
