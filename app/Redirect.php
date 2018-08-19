<?php

namespace App;

use App\Traits\SanitizesUrls;

class Redirect extends Model
{
    use SanitizesUrls;

    public function setSourceUrlAttribute($value)
    {
        $this->attributes['source_url'] =  $this->sanitizeRelativePath($value);
    }

    public function setRedirectUrlAttribute($value)
    {
        $this->attributes['redirect_url'] =  $this->sanitizePath($value);
    }
}
