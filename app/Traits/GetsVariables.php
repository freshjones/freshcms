<?php

namespace App\Traits;

trait GetsVariables
{

    public function variable_get($name=null,$default=null) 
    { 
        if(!$name)
          return;

        return config("settings.{$name}", $default);
    }
}
