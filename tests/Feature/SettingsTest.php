<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
    }

    /** @test */
    public function a_guest_can_not_administer_configurations()
    {
        $this->withExceptionHandling();

        $this->get('/settings/configuration')
            ->assertRedirect('/login');

        $this->post('/settings/configuration', [])
            ->assertRedirect('/login');
    }

     /** @test */
    public function an_authenticated_user_can_view_settings_configuration_screen()
    {
        $this->actingAs($this->user);
        
        $this->get('/settings/configuration')
            ->assertStatus(200);
    }

   
    /** @test */
    public function an_authenticated_user_can_submit_the_form()
    {
    
        $this->actingAs($this->user);

        $this->post('/settings/configuration', [
            'language' => 'en',
            'company' => 'FreshJones Creative',
            'tagline' => 'Building great web and mobile apps.',
            'front' => null,
            'theme' => 'default',
        ])->assertRedirect('/');
    }

    /**     
    * @test 
    */
    public function required_fields_cannot_be_empty()
    {
        $fields = ['language','company','theme'];

        foreach($fields AS $field) {

            try {
                $response = $this->actingAs($this->user)
                    ->post('/settings/configuration', [
                        'language' => $field == 'language' ? '' : 'en',
                        'company' => $field == 'company' ? '' : 'FreshJones Creative',
                        'tagline' => 'Building great web and mobile apps.',
                        'front' => null,
                        'theme' => $field == 'theme' ? '' : 'default',
                    ]);
            } catch (ValidationException $e) {

                $this->assertEquals(
                    "The $field field is required.",
                    $e->validator->errors()->first($field)
                );

                continue;
            
            }
            
            $this->fail("The $field field passed validation when it should have failed.");

        }

    }


}
