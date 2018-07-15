<?php

namespace App\Services\SectionProcessors;

class ProcessorLoader {

  public function load($section) {
    if(!$section || !isset($section['type']))
      return false;
    $name = "App\Services\SectionProcessors\\" . ucfirst($section['type']) . "Processor";
    return new $name($section);
  }

}
