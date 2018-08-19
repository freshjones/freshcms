<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class TrashRestoreControllerTest extends TestCase
{ 
    use RefreshDatabase;

    /** @test */
    function guest_cannot_restore_a_page_from_trash() {

        $this->withExceptionHandling();
        
        $page = create('App\Page');

        $this->get( route('trash.restore', $page->toArray() ) )
            ->assertStatus(302)
            ->assertRedirect('/login');
      
    }

    /** @test */
    function auth_users_can_restore_a_page_from_trash() {
    
        $this->signIn();

        $page = factory('App\Page', null)->states('trashed')->create();

        $this->get( route('trash.restore', $page ) )
            ->assertStatus(302)
            ->assertRedirect( route('trash.index') );

        $this->assertDatabaseHas('pages', ['id'=> $page->id]);
      
    }
    
}
