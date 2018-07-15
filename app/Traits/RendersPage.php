<?php

namespace App\Traits;

use App\Content;

trait RendersPage 
{

    function renderBySlug($slug=null) 
    {

        $theme = config('settings.theme','default');

        if(!$slug)
            return redirect()->route('home');

        $page = Content::whereHas('page', function ($query) use ($slug) {
            $query->where('slug', '=', $slug);
        })->where('lang','en')->first();

        if(!$page)
            abort(404, 'Page Not Found');

        return view("themes.{$theme}.page", compact('page'));

    }

}
