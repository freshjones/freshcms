<?php

namespace App\Services\SectionProcessors;

use Stevebauman\Purify\Facades\Purify;

class ContentProcessor extends Processor {

    public function set()
    {
        $this->section['data']['description'] = Purify::clean($this->section['data']['description']);
    }
    
}
