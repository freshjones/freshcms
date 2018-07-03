<?php

namespace App\Services\Sections;

class BillboardService extends SectionService
{

  public function __construct() {
    parent::__construct();
    $this->setContent('type','billboard');
    $this->setData('billboards',[]);
  }

}
