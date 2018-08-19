<?php

namespace App\Http\Controllers\Trash;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::onlyTrashed()->get();
        return view('admin.trash.index',compact('pages'));
    }

}
