<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\RendersPageView;
use App\Repositories\PageRepository as Repository;
/* models */
use App\Variables;

class HomeController extends Controller
{
    use RendersPageView;

    private $repo;

    public function __construct(Repository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        //get the proper template
        $vars = Variables::where('name','template')->orWhere('name', 'front')->get();
        $variables = array();

        collect($vars)->each(function($item) use (&$variables){
            $variables[$item->name] = $item->value;
        });
        
        if(empty($variables))
            return view("themes.empty");

        //if we have a homepage
        if($variables['front'] != 'default')
            return $this->renderPageBySlug($variables['front']);

        //get all pages
        $pages = $this->repo->all();
        
        //return the view
        return view("themes.{$variables['template']}.home", ['pages' => $pages]);
    }
}
