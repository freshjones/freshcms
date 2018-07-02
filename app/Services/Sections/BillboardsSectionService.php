<?php

namespace App\Services\Sections;

class BillboardsSectionService extends SectionService
{

  public function __construct() {
    parent::__construct();
    $this->setContent('type','billboards');
    $this->setData('billboards',[]);
  }

}
