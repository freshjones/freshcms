<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends FrontController
{
    public function index()
    {
        //->where('pages.display', '=', "1")
        $pages = DB::table('pages')
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->get();
            
        return view("themes.{$this->settings['template']}.home", ['pages' => $pages]);
    }
}
