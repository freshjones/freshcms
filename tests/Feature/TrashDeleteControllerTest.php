<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class TrashDeleteControllerTest extends TestCase
{ 
    use RefreshDatabase;

    /** @test */
    function a_guest_user_cannot_delete_a_page_from_trash() {

        $this->withExceptionHandling();
        
        $page = create('App\Page',[],null,'trashed');

        $this->get( route('trash.destroy', $page ) )
            ->assertStatus(302)
            ->assertRedirect('/login');
      
    }

    /** @test */
    function an_auth_user_can_delete_a_page_from_trash() {
        
        $this->signIn();

        $page = factory('App\Page', null)->states('trashed')->create();
        $page->contents()->save( make('App\Content') );

        $this->get( route('trash.destroy', $page ) )
            ->assertStatus(302)
            ->assertRedirect( route('trash.index') );
        
        //deleted the page
        $this->assertDatabaseMissing('pages', ['id'=> $page->id]);
        
        //deleted the contents
        $this->assertDatabaseMissing('contents', ['page_id'=> $page->id]);

    }

}
