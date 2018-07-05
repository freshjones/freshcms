<?php

namespace App\Traits;

trait GetsVariables
{

    public function variable_get($name=null,$default=null) 
    { 
        if(!$name)
          return;

        $variable = config("settings.{$name}");
      
        if(!$variable)
          $variable = $default;

        return $variable;
    }
}
