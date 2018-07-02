<?php

namespace App\Services\Sections;

class ContentSectionService extends SectionService
{
  
  public function __construct(){
    parent::__construct();
    $this->setContent('type','content');
    $this->setData('description', '');
  }

  private function storeFiles($files){

    foreach($files AS $file)
    {
        if ($file->isValid()) {
            $fileInfo = pathinfo($file->getClientOriginalName());
            $name = str_slug($fileInfo['filename'], '-');
            $path = $file->storeAs('public/images', "{$name}.{$file->extension()}");
        }
    }

  }
  
  public function processRequest($request){

    parent::processRequest($request);

    //store files 
    if($files = $request->file('photos'))
      $this->storeFiles($files);
      
    $this->setData('description', $request->description);

  }

}
