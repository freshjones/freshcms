<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PageRepository;
/* models */
use App\Content;

class SectionController extends Controller
{
    private $repo;
    private $sectionServiceLoader;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repo = new PageRepository();
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @param  int  $page_id
     * @return \Illuminate\Http\Response
     */
    public function index($page_id)
    {
        //load the page record
        $page = $this->repo->getByID($page_id);
        //return the contents
        return unserialize($page->content);
    }

    public function sort($page_id, Request $request)
    {
        //update the sort order
        Content::where([['page_id',$page_id],['lang','en']])->update(['content' => serialize( $request->all() ) ]);
        //return
        return ['message' => 'success'];   
    }

  
}
