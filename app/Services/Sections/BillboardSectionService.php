<?php

namespace App\Services\Sections;
use Ramsey\Uuid\Uuid;

class BillboardSectionService extends SectionService
{

  private $filepath;
  private $filename;

  public function __construct() {
    parent::__construct();
    $this->setContent('type','billboard');
  }

  private function storeFile($file){

    if ($file->isValid()) {
        $fileInfo = pathinfo($file->getClientOriginalName());
        $name = str_slug($fileInfo['filename'], '-');
        $this->filename = "{$name}.{$file->extension()}";
        $this->filepath = $file->storeAs('public/images', $this->filename);
    }

  }
  
  public function processRequest($request)
  {

    //store files 
    if($file = $request->file('background'))
      $this->storeFile($file);
    
    $billboard_id = !isset($request->billboard_id) || $request->billboard_id === 'create' ? Uuid::uuid1()->toString() : $request->billboard_id;
 
    $billboard = [
      'id' => $billboard_id,
      'label' => $request->label,
      'display' => $request->display,
      'heading' => $request->heading,
      'subheading' => $request->subheading,
      'link' => $request->link
    ];

    if($this->filename){
      $billboard['background'] = $this->filename;
    }

    $data = $this->getData();

    if(!isset($data['billboards']))
      $data['billboards'] = array();

    $billboards = $data['billboards'];

    if( isset($request->billboard_key) && is_numeric($request->billboard_key) && isset($billboards[$request->billboard_key]) )
    {
      $newBillboard = $billboards[$request->billboard_key];

      foreach($billboard AS $key => $value)
      {
        $newBillboard[$key] = $value;
      }
      $billboards[$request->billboard_key] = $newBillboard; 
    } else {
      $billboards[] = $billboard;
    }

    $this->setData('billboards',$billboards);

  }

}
