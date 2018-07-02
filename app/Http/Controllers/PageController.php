<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Page;
use App\Content;
use App\Variables;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $page = DB::table('pages')
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->where('pages.slug', '=', $slug)
            ->first();
        
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
        $template = Variables::where('name','template')->first();

        $page = DB::table('pages')
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->where('pages.slug', '=', $slug)
            ->first();
        
        $body = '';

        if(empty($page->content))
            return view("themes.{$template->value}.page", ['page' => $page, 'body' => $body]);

        $pageContent = unserialize($page->content);

        $collection = collect($pageContent)->where('display', 1);

        $collection->each(function ($section, $key) use (&$body) {
            /* @todo need a data processor here for each section type */
            if($section['type'] == 'billboards')
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
