<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Traits\RendersPageView;
use App\Repositories\PageRepository;

use App\Page;
use App\Content;
use App\Variables;

class PageController extends Controller
{

    use RendersPageView;

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
        $front = Variables::where('name','front')->first();

        if($slug == $front->value)
            return redirect()->route('home');
        
        return $this->renderPageBySlug($slug);
    }


}
