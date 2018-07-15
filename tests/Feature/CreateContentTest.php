<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateContentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_create_content()
    {
        $this->withExceptionHandling();

        $this->get('/content/create/1')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_content()
    {   
        $this->signIn();

        $content = create("App\Content",['content' => null]);

        $this->get('/content/create/'. $content->page->id)
            ->assertStatus(302)
            ->assertRedirect('/content/edit/' . $content->page->id . '/0' );
    }
    
}
