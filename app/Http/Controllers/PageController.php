<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PageRepository;
use Illuminate\Validation\Rule;

use App\Page;
use App\Content;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $front = config('settings.front');
        $theme = config('settings.theme','default');

        //if we have a homepage
        if(!is_null($front))
            return $this->renderBySlug($front);

        $pages = $this->repo->all();

        if(!$pages->all())
           return view("themes.empty"); 

        //return the view
        return view("themes.{$theme}.home", ['isFront' => true, 'pages' => $this->repo->all() ]);
  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $slug = str_slug($request->slug);
        
        $validatedData = $request->validate([
            'title' => 'required',
            'slug' => ['required',Rule::unique('pages')->ignore($slug),],
            'meta_description' => 'required',
        ]);

        $page = Page::create(['slug' => $slug])
            ->contents()
            ->create(request(['lang','title','meta_description']));
        
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

    public function update(Request $request, $slug)
    {

        $page = Page::where('slug',$slug)->first();

        $validatedData = $request->validate([
                'title' => 'required',
                'slug' => [
                    'required',
                    Rule::unique('pages')->ignore($page->id),
                ],
                'meta_description' => 'required',
            ],
            [
                'slug.unique' => "That URL is taken please choose a unique URL",
            ]);

        $slug = str_slug($request->slug);

        $page->update(['slug' => $slug]);

        $content = Content::where([['page_id',$page->id],['lang','en']])->update(request(['title','meta_description']));

        return redirect($slug);
        
    }

    public function show($slug)
    {
        if($slug == config('settings.front',null) )
            return redirect()->route('home');

        return $this->renderBySlug($slug);
    }


}
