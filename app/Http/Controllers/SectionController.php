<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Content;
use App\Services\Sections\SectionServiceLoader;

class SectionController extends Controller
{
    
    private $sectionServiceLoader;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sectionServiceLoader = new SectionServiceLoader();
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($page_id)
    {
        $page = DB::table('pages')
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->where('pages.id', '=', $page_id)
            ->first();

         return unserialize($page->content);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($pageID,$section)
    {
        /*
        $page = DB::table('pages')
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->where('pages.id', '=', $pageID)
            ->first();
        
        $this->sectionServiceLoader->setService($section);
        $service = $this->sectionServiceLoader->getService();
        $content = $service->getContent();
        $data = $service->getData();

        return view("admin.section.{$section}.create", ['page'=>$page, 'content' => $content, 'data' => $data ]);
        */
        
        $page = DB::table('pages')
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->where('pages.id', '=', $pageID)
            ->first();

        $this->sectionServiceLoader->setService($section);
        $service = $this->sectionServiceLoader->getService();
        $service->setContents($page->content);

        //set the display to draft mode
        $service->setContent('display',-1);
        $service->updateContents();

        $contents = $service->getContents(false);
        $keys = array_keys($contents);
        $last_key = array_pop($keys);

        //save to the database
        Content::where([['page_id',$pageID],['lang','en']])->update([ 'content' => $service->getContents() ]);
        
        //redirect to the edit screen
        return redirect()->route('section-edit', [$pageID, $last_key, $section]);

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($page, $id, $type)
    {
        
        $page = DB::table('pages')
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->where('pages.id', '=', $page)
            ->first();
        
        $this->sectionServiceLoader->setService($type);
        $service = $this->sectionServiceLoader->getService();
        $service->setContents($page->content);
        $service->loadContent($id);
        $content = $service->getContent();
        $data = $service->getData();

        return view("admin.section.{$type}.edit", ['page'=>$page, 'id' => $id, 'content' => $content, 'data' => $data ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $page_id, $key)
    {
        
        $page = DB::table('pages')
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->where('pages.id', '=', $page_id)
            ->first();
        
        $this->sectionServiceLoader->setService($request->type);
        $service = $this->sectionServiceLoader->getService();
        $service->setContents($page->content);
        $service->loadContent($key);
        $service->processRequest($request);
        $service->updateContents($key);

        //save to the database
        $content = Content::where([['page_id',$page_id],['lang','en']])->update(['content' => $service->getContents() ]);
       
        return redirect()->route('page-edit', [$page->slug]);

    }

    public function sort_update($page_id, Request $request)
    {
        $content = Content::where([['page_id',$page_id],['lang','en']])->update(['content' => serialize( $request->all() ) ]);
        echo json_encode(['message' => 'success']);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($page_id,$key,$type)
    {
        $page = DB::table('pages')
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->where('pages.id', '=', $page_id)
            ->first();

        $this->sectionServiceLoader->setService($type);
        $service = $this->sectionServiceLoader->getService();
        $service->setContents($page->content);
        $service->destroyContent($key);

        //save to the database
        $content = Content::where([['page_id',$page_id],['lang','en']])->update(['content' => $service->getContents() ]);
        
        //redirect to page edit
        return redirect()->route('page-edit', [$page->slug]);

    }
}
