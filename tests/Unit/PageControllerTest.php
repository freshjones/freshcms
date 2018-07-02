<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\User;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_displays_new_page_form()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
                         ->get('/page/create');

        $response->assertStatus(200);
    }

    public function test_displays_new_page_form_submit()
    {
        //seed the database
        $this->seed('VariablesTableSeeder');
        
        $slug = 'test-page';

        $user = factory(User::class)->create();

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

    public function test_displays_homepage()
    {
        $this->test_displays_new_page_form_submit(); 
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
