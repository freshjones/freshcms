<?php

namespace App\Services\SectionProcessors;

class BillboardProcessor extends Processor {

    public function set()
    {
        $billboards = array();

        if(
            isset($this->section['data']) && is_array($this->section['data']) &&
            isset($this->section['data']['billboards']) && is_array($this->section['data']['billboards'])
        )
            $billboards = $this->section['data']['billboards'];

        $collection = collect($billboards);
        $filtered = $collection->filter(function ($data, $key) {
            return isset($data['display']) && $data['display'] == 1;
        });
        $section['data']['billboards'] = $filtered->all();

    }
    
}
