<?php

namespace App\Http\Controllers\Trash;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrashRestoreController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * restore a page from trash
     * @return Response
     */
    public function __invoke(Page $page){
        
        $page->restore();

        return redirect()->route('trash.index');
    
    }

}
