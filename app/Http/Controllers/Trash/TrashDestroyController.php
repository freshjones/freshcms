<?php

namespace App\Http\Controllers\Trash;

use App\Http\Controllers\Controller;
use App\Page;
use App\Redirect;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrashDestroyController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
        $this->middleware('auth');

    }

    /**
     * restore a page from trash
     * @return Response
     */
    public function __invoke(Page $page) {
        
        //delete all redirects
        Redirect::where('redirect_url', $page->slug)->delete();

        //delete all contents
        $page->contents()->forceDelete();

        //delete page
        $page->forceDelete();

        //redirect
        return redirect()->route('trash.index');
    
    }

}
