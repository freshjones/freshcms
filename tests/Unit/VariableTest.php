<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VariableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_controller_has_variables()
    {
        $this->assertTrue(true);
    }
}
