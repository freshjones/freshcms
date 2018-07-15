<?php

namespace App\Services\SectionProcessors;

use Illuminate\Support\Facades\View;

interface ProcessorInterface 
{
    public function set();
    public function get();
    public function render();
}

abstract class Processor implements ProcessorInterface 
{

    protected $section;

    public function __construct($section)
    {
      $this->section = $section;
    }

    public function get()
    {
        return $this->section;
    }

    public function render()
    {
        $view = View::make("sections.{$this->section['type']}.{$this->section['style']}", ['id' => $this->section['id'], 'data' => $this->section['data']] );
        return $view->render();
    }

} 
