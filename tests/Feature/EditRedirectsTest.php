<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class EditRedirectsTest extends TestCase
{ 

    use RefreshDatabase;

    /** @test */
    function a_guest_cannot_edit_redirects() {

        $this->withExceptionHandling();

        $this->get('/admin/redirects/edit/1')
            ->assertStatus(302)
            ->assertRedirect('/login');

    }

    /** @test */
    function an_authenticated_user_can_edit_redirects() {

        $this->signin();

        $redirect = create('App\Redirect');

        $this->get("/admin/redirects/edit/{$redirect->id}")
            ->assertStatus(200)
            ->assertSee($redirect->source_url)
            ->assertSee($redirect->redirect_url);

        $this->patch("/admin/redirects/update/{$redirect->id}", $redirect->toArray())
            ->assertStatus(302)
            ->assertRedirect('/admin/redirects');

    }

    /** @test */
    public function required_redirect_fields_cannot_be_empty_when_editing()
    {
        
        $this->signIn();

        $redirect = create("App\Redirect");

        $fields = ['source_url','redirect_url','type'];

        foreach($fields AS $field) {

            $newRedirect = make("App\Redirect");
            
            $array = $newRedirect->toArray();

            $array[$field] = '';

            try {
                
                $response = $this->patch('/admin/redirects/update/' . $redirect->id, $array);

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



}
