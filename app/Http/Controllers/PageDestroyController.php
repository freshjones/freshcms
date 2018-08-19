<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageDestroyController extends Controller
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
     * Deletes a Page
     * @param  Request $request
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function __invoke(Request $request, int $id){
        
        Page::where('id',$id)->delete();
        
        return redirect('/');
    }
}
