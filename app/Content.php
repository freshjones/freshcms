<?php

namespace App;
use App\Observers\ContentObserver;
use App\Services\SectionProcessors\ProcessorLoader;

class Content extends Model
{
    
    public static function boot()
    {
        parent::boot();
        static::observe(new ContentObserver);
    }

    public function page()
    {
        return $this->belongsTo('App\Page');
    }

    public function revisions()
    {
        return $this->hasMany('App\Revision');
    }

    public function setContentAttribute($content)
    {
        $this->attributes['content'] =  serialize($content);
    }

    public function getContentAttribute($content)
    {
        return unserialize($content);
    }

    public function getRenderAttribute()
    {

        $processorLoader = new ProcessorLoader();

        $collection = collect($this->content);

        $collection->where('display', 1)
            ->sortBy('order');

        $body = '';
        $collection->each(function ($section) use (&$body,$processorLoader) 
        {
            $processor = $processorLoader->load($section);

            if(!$processor)
                return false;

            $processor->set();
            $body .= $processor->render();
        });

        return $body;

    }

}
