<?php

namespace App\Services\Sections;


class SectionServiceLoader
{

  private $service;

  public function setService($service){
    $this->service = $service;
  }

  public function getService()
  {
    $serviceName = ucfirst($this->service);
    $service = "\App\Services\Sections\\{$serviceName}SectionService";
    return new $service();
  }
}
