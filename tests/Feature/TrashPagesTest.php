<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class TrashPagesTest extends TestCase
{ 
    use RefreshDatabase;

    /** @test */
    function a_guest_cannot_trash_pages() {

        $this->withExceptionHandling();
        
        $page = create('App\Page');

        $this->delete( route('page.delete', $page->toArray() ) )
            ->assertStatus(302)
            ->assertRedirect('/login');
      
    }

    /** @test */
    function a_auth_user_can_trash_pages() {
        
        $this->signin();

        $page = create('App\Page');

        $this->delete( route('page.delete', $page->toArray() ) )
            ->assertStatus(302)
            ->assertRedirect('/');
        
        $this->assertSoftDeleted('pages', [
            'id' => $page->id
        ]);

    }
}
