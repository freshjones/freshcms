<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class RevertPageTest extends TestCase
{ 
    
    use RefreshDatabase;

    /** @test */
    function a_guest_cannot_revert_a_page_from_history() 
    {

        $this->withExceptionHandling();

        $content = create('App\Content');
        
        $content->title = "updated title";
        $content->save();

        $this->get( route('content-revert', [$content, $content->revisions->first()]) )
            ->assertStatus(302)
            ->assertRedirect('/login');

    }

    /** @test */
    function an_auth_user_can_revert_a_page_from_history() 
    {

        $this->signIn();

        $firstTitle = "My First Title";

        $content = create('App\Content',['title'=>$firstTitle]);
        
        $content->title = "updated title";
        $content->save();

        $response = $this->json("get", route('content-revert', [$content, $content->revisions->first()]) )
            ->assertJsonFragment(['content' => $content->content])
            ->assertJsonFragment(['title' => $firstTitle]);
  
    }

}
