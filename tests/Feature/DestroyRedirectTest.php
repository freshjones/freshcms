<?php

namespace Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyRedirectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_redirects()
    {
        $this->withExceptionHandling();

        $redirect = create('App\Redirect');

        $this->delete( route('redirects-destroy', $redirect->toArray() ) )
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    function an_auth_user_can_delete_redirects() {
        
        $this->signIn();

        $redirect = create('App\Redirect');

        $this->delete( route('redirects-destroy', $redirect->id ) )
            ->assertStatus(302)
            ->assertRedirect('/admin/redirects');
        
        $this->assertDatabaseMissing('redirects', ['id' => $redirect->id]);
      
    }
}
