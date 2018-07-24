<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest as Middleware;

class SluggifyUrl extends Middleware
{

    protected $sluggable = [
        'slug',
        'url',
    ];
    
    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {

        if (in_array($key, $this->sluggable))
            return str_slug($value);
        
        return $value;
        
    }
}
