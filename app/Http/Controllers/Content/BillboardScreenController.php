<?php
/**
 * Controller for billboard screens
 */

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PageRepository as Repository;
use App\Services\Sections\BillboardScreenService as SectionHelper;

/* models */
use App\Content;

class BillboardScreenController extends Controller
{
    
    private $repo;
    private $helper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repo = new Repository();
        $this->helper = new SectionHelper();
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @param  int  $page_id
     * @param  int  $section_key
     * @return \Illuminate\Http\Response
     */
    public function index($page_id, $section_key)
    { 
      //load the page record
      $page = $this->repo->getByID($page_id);

      //get the content
      $content = unserialize($page->content);

      //get the section we need by key
      $section = $content[$section_key];

      //get the section data array
      $sectionData = $section['data'];

      //return the screens to vue
      return $sectionData['billboards'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      //load the page record
      $page = $this->repo->getByID($request->page_id);

      //load the current page content into the helper class
      $this->helper->setContents($page->content);

      //load the billboard section we are adding a screen to by its key
      $this->helper->loadContent($request->section_id);

      //process the request data
      $this->helper->processRequest($request);

      //update the current page content with the new item
      $this->helper->updateContents($request->section_id);

      //save to the database
      Content::where([['page_id',$request->page_id],['lang','en']])->update(['content' => $this->helper->getContents() ]);

      //get the section data
      $data = $this->helper->getData();

      //return the screens to vue
      return $data['billboards'];

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $page_id
     * @param  int  $section_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort_update($page_id, $section_id, Request $request)
    {

      //load the page record
      $page = $this->repo->getByID($page_id);

      //load the current page content into the helper class
      $this->helper->setContents($page->content);
      
      //load the billboard section we are adding a screen to by its key
      $this->helper->loadContent($section_id);

      //set the content data to the request values
      $this->helper->setData('billboards', $request->all());

       //update the current page content with the new item
      $this->helper->updateContents($section_id);

      //save to the database
      Content::where([['page_id',$page_id],['lang','en']])->update(['content' => $this->helper->getContents() ]);

      //return it to vue
      return ['message' => 'success'];

    }


}
