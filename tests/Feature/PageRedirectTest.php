<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PageRedirectTest extends TestCase
{ 
    use RefreshDatabase;

    /** @test */
    function page_redirects_when_an_internal_redirect_exists() {

        //given
        //we have a page 
        //and that page has a redirect
        $content1 = create("App\Content");
        $content2 = create("App\Content");
        $redirect = create("App\Redirect", ["source_url" => $content1->page->slug, "redirect_url" => $content2->page->slug, "type" => "301"]);

        //when 
        //we visit that page
        $response = $this->call("get", "/{$content1->page->slug}");
      
        //then
        //we expect the page to redirect
        $this->assertEquals('301', $response->getStatusCode() );

        $this->assertEquals(URL::to($content2->page->slug), $response->getTargetUrl());
      
    }

    /** @test */
    function page_redirects_when_an_external_redirect_exists() {

        //given
        //we have a page 
        //and that page has a redirect
        $content = create("App\Content");
        $redirect = create("App\Redirect", ["source_url" => $content->page->slug, "redirect_url" => "https://www.google.com", "type" => "301"]);

        //when 
        //we visit that page
        $response = $this->call("get", "/{$content->page->slug}");
      
        //then
        //we expect the page to redirect
        $this->assertEquals('301', $response->getStatusCode() );

        $this->assertEquals('https://www.google.com', $response->getTargetUrl());
      
    }



}
