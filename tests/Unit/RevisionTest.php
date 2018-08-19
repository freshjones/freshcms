<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class RevisionTest extends TestCase
{ 
    use RefreshDatabase;

    /** @test */
    function revision_table_has_the_right_fields() {

        $content = create('App\Content');

        $content->title = 'changed';

        $content->save();

        $this->assertDatabaseHas('revisions', [
            'content_id' => $content->id,
            'title' => $content->title,
            'content' => serialize($content->content),
            'meta_description' => $content->meta_description,
            'meta_robot' => $content->meta_robot,
        ]);
      
    }
}
