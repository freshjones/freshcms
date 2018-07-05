<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Elequent\Collection;

class PageTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_page_has_content()
    {
        $page = factory('App\Page')->create();
        
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $page->contents);
    }
}
