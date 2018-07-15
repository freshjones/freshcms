<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateBillboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_create_a_billboard()
    {
        $this->withExceptionHandling();

        $this->get('/billboard/create/1')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_a_billboard()
    {   
        $this->signIn();

        $content = create("App\Content",['content' => null]);

        $this->get('/billboard/create/'. $content->page->id)
            ->assertStatus(302)
            ->assertRedirect('/billboard/edit/' . $content->page->id . '/0' );
    }

}
