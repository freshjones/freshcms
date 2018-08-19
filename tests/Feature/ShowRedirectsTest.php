<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class ShowRedirectsTest extends TestCase
{   

    use RefreshDatabase;

    /** @test */
    function a_guest_cannot_access_redirects_index() {

        $this->withExceptionHandling();

        $this->get('/admin/redirects')
            ->assertRedirect('/login');

    }

    /** @test */
    function an_authenticated_user_can_view_redirects() {

        $this->signIn();
        
        $redirect = create('App\Redirect', ['source_url' => 'some-source', 'redirect_url' => 'some-redirect',]);

        $this->get('/admin/redirects')
            ->assertSee( 'some-source' )
            ->assertSee( 'some-redirect' );

    }

    /** @test */
    function when_there_are_no_redirects_a_default_message_is_shown() {

        $this->signIn();
        
        $this->get('/admin/redirects')
            ->assertSee('There are currently no redirects.');

    }


    

}
