<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditContentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_edit_content()
    {
        $this->withExceptionHandling();

        $this->get('/content/edit/1/0')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_view_edit_content_screen()
    {
        $this->signIn();

        $content = create("App\Content",['content' => null]);

        $this->get('/content/edit/' . $content->page->id . '/0')
            ->assertStatus(200);
    }

    /** @test */
    public function an_authenticated_user_can_edit_content()
    {
        
        $key = 0;

        $newText = 'This is some new random text';
        $newLabel = 'some new label';

        $this->withExceptionHandling()->signIn();

        //create a new page and content and persist it
        $page = create("App\Page");
        $page->contents()->save(make('App\Content'));

        $response = $this->patch("/content/update/{$page->id}/{$key}", [
                'label' => $newLabel,
                'description' => $newText,
                'display' => 1,
            ])->assertStatus(302);

        $page = \App\Page::with('contents')->find($page->id);

        $pageContent = $page->contents()->first()->content[$key];
       
        $this->assertSame($newText, $pageContent['data']['description']);
        $this->assertSame($newLabel, $pageContent['label']);
        $this->assertSame(1, $pageContent['display']);

    }

}
