<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

use App\Repositories\PageRepository;

use App\Page;
use App\Content;
use App\Variables;

class PageController extends Controller
{
    private $repo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repo = new PageRepository();
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return view('home');
    }

    public function create()
    {
        $page = new \stdClass;
        $page->title = '';
        $page->slug = '';
        $page->meta_description = '';
        return view('admin.page.create', compact('page'));
    }
    
    public function store(Request $request)
    {
        $slug = str_slug($request->slug);
        $page = Page::create(['slug' => $slug])
            ->contents()->create(request(['lang','title','meta_description']));
        return redirect($slug);
    }

    public function edit($slug)
    {
        
        $page = $this->repo->getBySlug($slug);

        if(empty($page->content))
            return view('admin.page.edit', ['page' => $page, 'contents' => array()]);

        $collection = collect( unserialize($page->content) )
            ->map(function ($item, $key) {
                
                 if(!isset($item['display']))
                    $item['display'] = -1;

                $item['status'] = 'draft';
                switch($item['display'])
                {
                    case 0:
                        $item['status'] = 'Unpublished';
                    break;

                    case 1:
                        $item['status'] = 'Published';
                    break;
                }
                
                if(!isset($item['order']))
                    $item['order'] = 0;

                if(!isset($item['type']))
                    $item['type'] = 'content';

                return $item;
            })
            ->sortBy('order');

        return view('admin.page.edit', ['page' => $page, 'contents' => $collection]);
    }

    public function update(Request $request,$slug)
    {
        $page = Page::where('slug',$slug)->first();
        $page->update(request(['slug']));
        $content = Content::where([['page_id',$page->id],['lang','en']])->update(request(['title','meta_description']));
        return redirect($request->slug);
    }

    public function show($slug)
    {
        //get the correct template
        $template = Variables::where('name','template')->first();

        //load the page by slug
        $page = $this->repo->getBySlug($slug);

        //start a body variable
        $body = '';

        //early exit
        if(empty($page->content))
            return view("themes.{$template->value}.page", ['page' => $page, 'body' => $body]);

        //unserialize the content
        $pageContent = unserialize($page->content);

        //create a collection of sections
        $collection = collect($pageContent)->where('display', 1);

        //loop through the collection and render each section
        $collection->each(function ($section, $key) use (&$body) {

            if($section['type'] == 'billboards') $section['type'] = 'billboard';

            /* @todo need a data helper here for each section type */
            if($section['type'] == 'billboard')
            {   
                $billboards = array();

                if(
                    isset($section['data']) && is_array($section['data']) &&
                    isset($section['data']['billboards']) && is_array($section['data']['billboards'])
                )
                    $billboards = $section['data']['billboards'];

                $collection = collect($billboards);
                $filtered = $collection->filter(function ($data, $key) {
                    return isset($data['display']) && $data['display'] == 1;
                });
                $section['data']['billboards'] = $filtered->all();
            }
            $view = View::make("sections.{$section['type']}.{$section['style']}", ['id' => $section['id'], 'data' => $section['data']] );
            $body .= $view->render();
        });
        
        return view("themes.{$template->value}.page", ['page' => $page, 'body' => $body]);
    }


}
