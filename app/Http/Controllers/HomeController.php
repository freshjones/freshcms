<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\PageRepository as Repository;
/* models */
use App\Variables;

class HomeController extends Controller
{
    private $repo;

    public function __construct(Repository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        //get the proper template
        $template = Variables::where('name','template')->first();

        //get all pages
        $pages = $this->repo->all();
        
        //return the view
        return view("themes.{$template->value}.home", ['pages' => $pages]);
    }
}
