<?php
/**
 * Controller for content
 */

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use App\Repositories\PageRepository as Repository;
use App\Services\Sections\BillboardService as SectionHelper;

class BillboardController extends BaseContentController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(new Repository(), new SectionHelper());
    }


}
