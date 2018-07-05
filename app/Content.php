<?php

namespace App;

class Content extends Model
{

    public function page()
    {
        return $this->belongsTo('App\Page');
    }

}
