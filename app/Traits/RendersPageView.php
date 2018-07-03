<?php

namespace App\Traits;
use Illuminate\Support\Facades\View;
use App\Variables;

trait RendersPageView
{

    public function renderPageBySlug($slug)
    {

        //get the correct template
        $template = Variables::where('name','template')->first();

        //load the page by slug
        $page = $this->repo->getBySlug($slug);

        //start a body variable
        $body = '';

        //early exit
        if(empty($page->content))
            return view("themes.{$template->value}.page", ['page' => $page, 'body' => $body]);

        //unserialize the content
        $pageContent = unserialize($page->content);

        //create a collection of sections
        $collection = collect($pageContent)->where('display', 1);

        //loop through the collection and render each section
        $collection->each(function ($section, $key) use (&$body) {

            if($section['type'] == 'billboards') $section['type'] = 'billboard';

            /* @todo need a data helper here for each section type */
            if($section['type'] == 'billboard')
            {   
                $billboards = array();

                if(
                    isset($section['data']) && is_array($section['data']) &&
                    isset($section['data']['billboards']) && is_array($section['data']['billboards'])
                )
                    $billboards = $section['data']['billboards'];

                $collection = collect($billboards);
                $filtered = $collection->filter(function ($data, $key) {
                    return isset($data['display']) && $data['display'] == 1;
                });
                $section['data']['billboards'] = $filtered->all();
            }
            $view = View::make("sections.{$section['type']}.{$section['style']}", ['id' => $section['id'], 'data' => $section['data']] );
            $body .= $view->render();
        });

        return view("themes.{$template->value}.page", ['page' => $page, 'body' => $body]);
    }

}
