<?php
namespace App\Http\Controllers;

use App\Content;
use App\Page;
use App\Redirect;
use App\Repositories\PageRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $this->middleware('slugify', ['only' => ['store', 'update']]);
        $this->middleware('page.redirects', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $now = Carbon::now();
        $front = config('settings.front');
        $theme = config('settings.theme', 'default');

        //if we have a homepage
        if (!is_null($front)) {
            return $this->renderBySlug($front);
        }
        // unplublish_at 2018-08-13 23:59:59 
        // now 2018-08-14 21:42:26.192803
        $pages = Content::whereHas('page', function ($query) use ($now) {
            
            $query->where('display', '=', 1);
            
            $query->where(function($query) use ($now) {
                $query->where('publish_at', '<=', $now->copy()->startOfDay() );
                $query->orWhereNull('publish_at', null);
            });
            
            $query->where(function($query) use ($now) {
                $query->where('unpublish_at', '>=', $now->copy() );
                $query->orWhereNull('unpublish_at', null);
            });

        })->where('lang','en')->get();

        if (!$pages->count()) {
            return view("themes.empty");
        }

        //return the view
        return view("themes.{$theme}.home", ['isFront' => true, 'pages' => $pages ]);

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
        $validatedData = $request->validate([
            'title' => 'required',
            'slug' => ['required','unique:pages',],
            'meta_description' => 'required',
        ]);

        $page = Page::create(['slug' => $request->slug])
            ->contents()
            ->create(request(['lang','title','meta_description']));
        
        return redirect($request->slug);
    }

    /**
     * @param  string $slug
     * @return Illuminate\Http\Response
     */
    public function edit(string $slug)
    {
        $page = Content::whereHas('page', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->with(['revisions' => function ($query)  {
            $query->orderBy('created_at', 'desc');
        }])
        ->where('lang','en')->first();
        
        if (!$page) {
            abort(404, "The page doesn't exist");
        }

        if (empty($page->content)) {
            return view('admin.page.edit', ['page' => $page, 'contents' => array()]);
        }

        $collection = collect($page->content)
            ->map(function ($item, $key) {
                if (!isset($item['display'])) {
                    $item['display'] = -1;
                }

                $item['status'] = 'draft';

                switch ($item['display']) {
                    case 0:
                        $item['status'] = 'Unpublished';
                    break;

                    case 1:
                        $item['status'] = 'Published';
                    break;
                }
                
                if (!isset($item['order'])) {
                    $item['order'] = 0;
                }

                if (!isset($item['type'])) {
                    $item['type'] = 'content';
                }

                return $item;
            })
            ->sortBy('order');

        return view('admin.page.edit', ['page' => $page, 'contents' => $collection]);
    }

    public function update(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->first();

        if (!$page) {
            abort(404, "The page doesn't exist");
        }

        $validatedData = $request->validate(
            [
                'title' => 'required',
                'slug' => [
                    'required',
                    Rule::unique('pages')->ignore($page->id),
                ],
                'unpublish_at' => 'nullable|after_or_equal:publish_at',
                'meta_description' => 'required',
            ],
            [
                'slug.unique' => "That URL is taken please choose a unique URL",
            ]);
        
        $page->update(request(['publish_at', 'unpublish_at']));

        if($request->slug != $page->slug){
            
            Redirect::where('source_url', $request->slug)->delete();

            Redirect::where('redirect_url', $page->slug)->update(['redirect_url' => $request->slug]);

            $page->update(['slug' => $request->slug]);

            Redirect::create([
                'source_url' => $slug, 
                'redirect_url' => $request->slug,
                'type' => '301',
            ]);

        }

        $content = Content::where([['page_id',$page->id],['lang','en']])->first();

        $content->title = $request->title;
        $content->meta_description = $request->meta_description;

        $content->save();

        if (request()->wantsJson()) {
            return response($content, 201);
        }

        return redirect($request->slug);
    }
    
    public function show($slug)
    {
        if ($slug == config('settings.front', null)) {
            return redirect()->route('home');
        }

        return $this->renderBySlug($slug);
    }
}
