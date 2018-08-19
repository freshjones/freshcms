<?php

function create($class, $attributes = [], $count=null, $state=null)
{
    if(!$state)
        return factory($class,$count)->create($attributes);

    return factory($class,$count)->states($state)->create($attributes);
    
}

function make($class, $attributes = [], $count=null)
{
  return factory($class,$count)->make($attributes);
}
