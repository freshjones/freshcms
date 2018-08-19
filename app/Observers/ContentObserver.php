<?php

namespace App\Observers;

use App\Content;
use App\Revision;
use Illuminate\Support\Facades\Log;

class ContentObserver
{

    /**
     * Handle to the content "created" event.
     *
     * @param  \App\Content  $content
     * @return void
     */
    public function created(Content $content)
    {
        Revision::create([
            "content_id" => $content->id,
            "lang" => $content->lang,
            "title" => $content->title,
            "meta_description" => $content->meta_description,
            "meta_robot" => $content->meta_robot,
            "content" => $content->content,
        ]);
    }

    /**
     * Handle to the content "updated" event.
     *
     * @param  \App\Content  $content
     * @return void
     */
    public function updated(Content $content)
    {
        Revision::create([
            "content_id" => $content->id,
            "lang" => $content->lang,
            "title" => $content->title,
            "meta_description" => $content->meta_description,
            "meta_robot" => $content->meta_robot,
            "content" => $content->content,
        ]);
    }

}
