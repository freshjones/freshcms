<?php
/**
 * Controller for billboards
 */
namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


/* models */
use App\Content;

abstract class BaseContentController extends Controller
{

    private $repo;
    private $helper;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($repo,$helper)
    {
        $this->repo = $repo;
        $this->helper = $helper;
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     * @param  int  $page_id
     * @return \Illuminate\Http\Response
     */
    public function create($page_id)
    {
        //load the page record
        $page = $this->repo->getByID($page_id);
   
        //load the current page content into the helper class
        $this->helper->setContents($page->content);

        //set the new content display value to draft mode
        $this->helper->setContent('display',-1);
        
        //update the current page content with the new item
        $this->helper->updateContents();

        //save the new content to the database
        Content::where([['page_id',$page_id],['lang','en']])->update([ 'content' => $this->helper->getContents() ]);
        
        //get the last key so we can redirect to the edit screen
        $keys = array_keys($this->helper->getContents(false));
        $last_key = array_pop($keys);

        $route = $this->helper->getType() . '-edit';

        //redirect to the edit screen
        return redirect()->route($route, [$page_id, $last_key]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $page_id
     * @param  int  $section_key
     * @return \Illuminate\Http\Response
     */
    public function edit($page_id, $section_key)
    {
        //load the page record
        $page = $this->repo->getByID($page_id);

        //set the current page content into the helper class
        $this->helper->setContents($page->content);

        //set the current content using the key
        $this->helper->loadContent($section_key);

        //get the content from the helper class
        $content = $this->helper->getContent();

        //separate the data from the content for the view
        $data = $this->helper->getData();

        $view = 'admin.section.' . $this->helper->getType() . '.edit';

        return view($view, ['page'=>$page, 'id' => $section_key, 'content' => $content, 'data' => $data ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $page_id
     * @param  int  $section_key
      * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($page_id, $section_key, Request $request)
    {
        
        $validatedData = $request->validate([
            'label' => 'required',
        ]);

        //load the page record
        $page = $this->repo->getByID($page_id);
        
        //set the current page content into the helper class
        $this->helper->setContents($page->content);
        
        //load the section we are updating by its key
        $this->helper->loadContent($section_key);

        //process the request data
        $this->helper->processRequest($request);

        //update the page content with the new content
        $this->helper->updateContents($section_key);

        //save to the database
        Content::where([['page_id',$page_id],['lang','en']])->update(['content' => $this->helper->getContents() ]);
     
        //redirect to the edit screen of the page
        return redirect()->route('page-edit', [$page->slug]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $page_id
     * @param  int  $section_key
     * @return \Illuminate\Http\Response
     */
    public function destroy($page_id,$section_key)
    {
        //load the page record
        $page = $this->repo->getByID($page_id);
        
        //set the current page content into the helper class
        $this->helper->setContents($page->content);

        //remove the section by its key
        $this->helper->destroyContent($section_key);

        //save to the database
        Content::where([['page_id',$page_id],['lang','en']])->update(['content' => $this->helper->getContents() ]);
        
        //redirect to the edit screen of the page
        return redirect()->route('page-edit', [$page->slug]);
    }
    
}
