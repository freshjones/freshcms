<?php

namespace App\Http\Controllers\Content;

use App\Content;
use App\Http\Controllers\Controller;
use App\Revision;
use Illuminate\Http\Request;

class ContentRevertController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * restore a page from trash
     * @return Response
     */
    public function __invoke(Request $request, Content $content, Revision $revision){
        
        $content->title = $revision->title;
        $content->meta_description = $revision->meta_description;
        $content->meta_robot = $revision->meta_robot;
        $content->content = $revision->content;

        $content->save();
            
        if (request()->wantsJson()) {
            return response($content, 201);
        }

        return redirect($content->page->slug);
    }

}
