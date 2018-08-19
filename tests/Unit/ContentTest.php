<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function content_has_a_page()
    {
    
        $content = factory('App\Content')->create();
        
        $this->assertInstanceOf('App\Page', $content->page);

    }

    /** @test */
    public function content_has_revisions()
    {
    
        $content = factory('App\Content')->create();
        
        $this->assertEquals(1, $content->revisions()->count());

    }

}
