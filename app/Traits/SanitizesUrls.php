<?php

namespace App\Traits;

use App\Content;
use Illuminate\Support\Facades\URL;

trait SanitizesUrls 
{   

    function isValidUrl($value)
    {
        
        $patten = '%^(?:(?:https?)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu';

        return preg_match($patten, $value);
    }

    function sanitizePath($value)
    {
        $value = trim($value);

        $base_path = URL::to('/');

        if($this->isValidUrl($value))
            return $this->sanitizeAbsolutePath($value);
     
        return $this->sanitizeRelativePath($value);
      
    }

    function isExternalUrl($host)
    {
        $base_path = parse_url(URL::to('/'));
        $base_url = $base_path['host'];

        return $host == $base_url ? false : true;
    }

    function sanitizeAbsolutePath($value) 
    {
        $url = parse_url($value);

        if(!isset($url['path']))
            $url['path'] = '/';
        
        $url['path'] = $this->sanitizeRelativePath($url['path']);

        if($this->isExternalUrl($url['host']))
            return http_build_url($url);

        return $url['path'];
 
    }

    function sanitizeRelativePath($value) 
    {

        //trim space
        $value = trim($value, " \t\n\r\0\x0B/");

        //lower case
        $value = strtolower($value);

        //strip any unwanted characters
        $value = preg_replace ('%[^\w\d\s-/]%iu', '', $value);

        //replace spaces
        $value = preg_replace ('%[\s]%iu', '-', $value);

        //strip double slashes
        $value = preg_replace('%/+%','/',$value);

        return $value;

    }

}
