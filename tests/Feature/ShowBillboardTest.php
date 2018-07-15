<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowBillboardTest extends TestCase
{

    private $billboardContent; 

    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->billboardContent = require(__DIR__ . '/../fixtures/billboardContent.php');
    }
    
    /** @test */
    public function a_page_shows_active_billboards()
    {   
        $contents = create('App\Content', ['content' => serialize($this->billboardContent)]);
        $response = $this->get("/{$contents->page->slug}");
        foreach($this->billboardContent[0]['data']['billboards'] as $billboard)
        {
            $response->assertSee($billboard['heading']); 
        }
    }
}
