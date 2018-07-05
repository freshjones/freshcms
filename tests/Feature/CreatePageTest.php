<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePageTest extends TestCase
{
    
    use RefreshDatabase;

    public function test_displays_new_page_form()
    {
        $user = factory('App\User')->create();

        $response = $this->actingAs($user)
                         ->get('/page/create');

        $response->assertStatus(200);
    }
   
    public function test_displays_new_page_form_submit()
    {
      
        $slug = 'test-page';

        $user = factory('App\User')->create();

        $response = $this->actingAs($user)
                         ->post('/page', [
            'title' => 'blah',
            'slug' => $slug,
            'lang' => 'en',
            'meta_description' => 'my description',
        ]);

        //redirect to slug 
        $response->assertRedirect($slug);
    }

}
