<?php

namespace App\Traits;

use App\Content;
use App\Redirect;
use App\Traits\SanitizesUrls;
use Carbon\Carbon;

trait RendersPage 
{

    use SanitizesUrls;

    function renderBySlug($slug=null) 
    {
        $now = Carbon::now();

        $theme = config('settings.theme','default');

        if(!$slug)
            return redirect()->route('home');

        //if unpublish date is greater than or equal to now than display
        //now 2018-09-17 23:59:59.999999
        //unpublish_at 2018-09-17 23:59:59
        $page = Content::whereHas('page', function ($query) use ($slug,$now) {
            $query->where('slug', '=', $slug)
                ->where(function($q) use ($now) {
                  $q->where('publish_at', '<=', $now)
                    ->orWhereNull('publish_at');
                })
                ->where(function($q) use ($now) {
                  $q->where('unpublish_at', '>=', $now)
                    ->orWhereNull('unpublish_at');
                });
        })->where('lang','en')->first();

        if(!$page)
            $this->abort($slug);
           
        return view("themes.{$theme}.page", compact('page'));

    }

    function abort($slug)
    {
        abort(404, 'Page Not Found');
    }

}
