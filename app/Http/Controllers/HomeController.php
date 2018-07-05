<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\RendersPageView;
use App\Repositories\PageRepository as Repository;

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
        $front = $this->variable_get('front');
        $theme = $this->variable_get('theme','default');
        
        //if we have a homepage
        if(!is_null($front))
            return $this->renderPageBySlug($front);

        //return the view
        return view("themes.{$theme}.home", ['pages' => $this->repo->all() ]);
    }
}
