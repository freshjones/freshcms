<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateRedirectsTest extends TestCase
{ 

    use RefreshDatabase;

    /** @test */
    function a_guest_cannot_add_redirects() {

        $this->withExceptionHandling();

        $this->get('/admin/redirects/create')
            ->assertStatus(302)
            ->assertRedirect('/login');

    }

     /** @test */
    public function required_redirect_fields_cannot_be_empty()
    {
        
        $this->signIn();

        $fields = ['source_url','redirect_url','type'];

        foreach($fields AS $field) {

            $redirect = make("App\Redirect");
            
            $array = $redirect->toArray();

            $array[$field] = '';

            try {
                
                $response = $this->post('/admin/redirects/store', $array);

            } catch (ValidationException $e) {

                $this->assertEquals(
                    "The " . str_replace('_', ' ', $field) . " field is required.",
                    $e->validator->errors()->first($field)
                );

                continue;
            
            }
            
            $this->fail("The $field field passed validation when it should have failed.");

        }

    }

    /** @test */
    function an_authenticated_user_can_add_redirects() {

        $this->signIn();
        
        $redirect = make("App\Redirect");

        $response = $this->post("/admin/redirects/store", $redirect->toArray() )
            ->assertStatus(302)
            ->assertRedirect('/admin/redirects');

    }

    /** @test */
    function the_source_url_is_sanitized() {
        
        $this->signIn();
        
        $redirect = make("App\Redirect", ['source_url' => '/this_Thing He?re/should Wor...k/as Exp!ected<? ']);

        $this->json('post', route('redirects-store'), $redirect->toArray())
            ->assertJsonFragment(['source_url' => 'this_thing-here/should-work/as-expected']);
    }

    /** @test */
    function a_relative_redirect_url_is_sanitized() {
        
        $this->signIn();
        
        $redirect = make("App\Redirect", ['redirect_url' => '/this_Thing He?re//should Wor...k/as Exp!ected<? ']);

        $this->json('post', route('redirects-store'), $redirect->toArray())
            ->assertJsonFragment(['redirect_url' => "this_thing-here/should-work/as-expected"]);
    }

    /** @test */
    function an_external_absolute_redirect_url_is_allowed() {
        
        $this->signIn();
        
        $redirect = make("App\Redirect", ['redirect_url' => 'https://www.google.com ']);

        $this->json('post', route('redirects-store'), $redirect->toArray())
            ->assertJsonFragment(['redirect_url' => 'https://www.google.com']);
    }

    /** @test */
    function an_internal_absolute_redirect_url_is_allowed() {
        
        $this->signIn();
        
        $base_url = URL::to('/');

        $redirect = make("App\Redirect", ['redirect_url' => "{$base_url}/http//freshcmstest//hello-goodbye "]);

        $this->json('post', route('redirects-store'), $redirect->toArray())
            ->assertJsonFragment(['redirect_url' => "http/freshcmstest/hello-goodbye"]);

    }

    /** @test */
    function source_and_redirect_urls_cant_be_the_same() {
        
        $this->withExceptionHandling()->signIn();

        $redirect = make("App\Redirect", ['source_url' => "same",'redirect_url' => "same"]);

        $response = $this->post( route('redirects-store'), $redirect->toArray() )
            ->assertSessionHasErrors('redirect_url');
    }

    /** @test */
    function source_urls_must_be_unique() {
        
        $this->withExceptionHandling()->signIn();

        $redirect1 = create("App\Redirect", ['source_url' => "same"]);

        $redirect2 = make("App\Redirect", ['source_url' => "same"]);

        $this->post( route('redirects-store'), $redirect2->toArray() )
            ->assertSessionHasErrors('source_url');
    }

    

}
