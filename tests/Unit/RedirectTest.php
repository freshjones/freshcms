<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RedirectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function redirect_model_has_correct_fields()
    {

        $redirect = factory('App\Redirect')->create();

        $this->assertDatabaseHas('redirects', [
            'redirect_url' => $redirect->redirect_url,
            'source_url' => $redirect->source_url,
            'type' => $redirect->type
        ]);

    }
}
