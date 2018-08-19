<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class ShowTrashTest extends TestCase
{ 
    use RefreshDatabase;

    /** @test */
    function guests_cannot_see_trash_list_view() {

        $this->withExceptionHandling();

        $this->get('/admin/trash')
            ->assertRedirect('/login');
      
    }

    /** @test */
    function an_authenticated_user_can_view_trash() {

        $this->signIn();
        
        $page = create('App\Page');

        $page->delete();

        $this->get('/admin/trash')
            ->assertStatus(200)
            ->assertSee( $page->slug );

    }

}
