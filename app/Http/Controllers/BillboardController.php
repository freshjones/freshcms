<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Sections\SectionServiceLoader;
use App\Content;
use Ramsey\Uuid\Uuid;

class BillboardController extends Controller
{
    //
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

    public function index($page, $section)
    { 
      $page = DB::table('pages')
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->where('pages.id', '=', $page)
            ->first();

      $allContent = unserialize($page->content);

      $sectionContent = $allContent[$section];

      $sectionData = $sectionContent['data'];

      return $sectionData['billboards'];
   
    }

    /*
    * We're adding a billboard to the billboards section
    */
    public function store(Request $request)
    {

      $page = DB::table('pages')
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->where('pages.id', '=', $request->page_id)
            ->first();

      $this->sectionServiceLoader->setService('billboard');
      $service = $this->sectionServiceLoader->getService();
      $service->setContents($page->content);
      $service->loadContent($request->section_id);
      $service->processRequest($request);
      $service->updateContents($request->section_id);

      //save to the database
      $content = Content::where([['page_id',$request->page_id],['lang','en']])->update(['content' => $service->getContents() ]);

      $data = $service->getData();

      //return it to the screen
      echo json_encode( $data['billboards'] );

    }

    /*
    * We're updating a billboard in the billboards section
    */
    public function update(Request $request)
    {

      //get the page
      $page = DB::table('pages')
        ->join('contents', function ($join) {
            $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
        })
        ->where('pages.id', '=', $request->page_id)
        ->first();

      $this->sectionServiceLoader->setService('billboard');
      $service = $this->sectionServiceLoader->getService();
      $service->setContents($page->content);
      $service->loadContent($request->section_id);
      $service->processRequest($request);
      $service->updateContents($request->section_id);

      //save to the database
      $content = Content::where([['page_id',$request->page_id],['lang','en']])->update(['content' => $service->getContents() ]);

      $data = $service->getData();

      //return it to the screen
      return $data['billboards'];
    }

    public function sort_update($page_id, $section, Request $request)
    {

      $page = DB::table('pages')
          ->join('contents', function ($join) {
              $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
          })
          ->where('pages.id', '=', $page_id)
          ->first();

      $this->sectionServiceLoader->setService('billboard');
      $service = $this->sectionServiceLoader->getService();
      $service->setContents($page->content);
      $service->loadContent($section);
      $service->setData('billboards', $request->all());
      $service->updateContents($section);

      $content = Content::where([['page_id',$page_id],['lang','en']])->update(['content' => $service->getContents() ]);

      $data = $service->getData();

      //return it to the screen
      echo json_encode(['message' => 'success']);

    }

    

}
