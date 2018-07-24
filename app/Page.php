<?php

namespace App;

class Page extends Model
{
  
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function contents()
    {
        return $this->hasMany('App\Content');
    }
    /*
    protected static function boot()
    {
        parent::boot();

        static::updating(function(){});
    }
    */
}
