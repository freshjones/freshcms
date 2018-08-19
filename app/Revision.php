<?php

namespace App;

class Revision extends Model
{
    public function setContentAttribute($content)
    {
        $this->attributes['content'] =  serialize($content);
    }

    public function getContentAttribute($content)
    {
        return unserialize($content);
    }

}
