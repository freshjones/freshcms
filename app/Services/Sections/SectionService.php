<?php

namespace App\Services\Sections;

use Ramsey\Uuid\Uuid;

abstract class SectionService
{

  private $contents;
  private $content;

  public function __construct(){
    $this->init();
  }

  public function init() 
  {
    $this->content = [
      'id' => '',
      'type' => '',
      'label' => '',
      'order' => null,
      'display' => 1,
      'style' => 'default',
      'data' => array(),
    ];
  }

  /* when we have no key we're creating */
  private function getLastKey()
  {
    $contents = $this->contents;

    if(empty($contents))
      return null;

    $keys = array_keys($contents);
    return array_pop($keys);
  }

  public function loadContent($key=null) 
  {

    if(is_null($key))
      return;

    $content = collect($this->contents)->only($key)->first();

    if(!$content)
      return;

    if(isset($content['id']))
      $this->setContent('id', $content['id']);

    if(isset($content['type']))
      $this->setContent('type', $content['type']);

    if(isset($content['label']))
      $this->setContent('label', $content['label']);

    if(isset($content['order']))
      $this->setContent('order', $content['order']);

    if(isset($content['display']))
      $this->setContent('display', $content['display']);

    if(isset($content['style']))
      $this->setContent('style', $content['style']);

    if(!isset($content['data']) || empty($content['data']))
      return;

    $data = collect($content['data'])->reject(function ($name) {
      return empty($name);
    })->each(function ($value, $name) {
      $this->setData($name, $value);
    });

  }

  public function setContent($name,$value){
    if(!isset($this->content[$name]))
      $this->content[$name] = '';
    $this->content[$name] = $value;
  }

  public function getContent(){
    return $this->content;
  }

  public function setData($name, $value)
  {
    if(!isset($this->content['data'][$name]))
      $this->content['data'][$name] = '';
    $this->content['data'][$name] = $value;
  }

  public function unsetData($names)
  {
    foreach($names AS $name) {
      $this->content['data'][$name] = '';
    };
  }

  public function setType($value){
    if(empty($this->content['type']) )
      $this->setContent('type',$value);
  }

  public function setID(){
    if(empty($this->content['id']))
      $this->setContent('id',Uuid::uuid1()->toString());
  }

  public function getData(){
    return $this->content['data'];
  }

  public function processRequest($request) {

    //set ID
    $this->setID($request->id);

    if(isset($request->type))
      $this->setType($request->type);

    //set label
    if(isset($request->label))
      $this->setContent('label', $request->label);

    //set order
    $this->setContent('order', $this->setOrder() );

    if(isset($request->order) && is_int($request->order) )
      $this->setContent('order', $request->order);

    if(isset($request->display) && in_array($request->display,[0,1]) )
      $this->setContent('display', $request->display);

    //set style
    if(isset($request->style))
      $this->setContent('style', $request->style);
    
  }

  public function setContents($contents, $unserialize=true) {
    if(!$unserialize){
      $this->contents = $contents;
      return;
    }
    $this->contents = unserialize($contents);
  }

  public function getContents($serialize=true) {
    if(!$serialize)
      return $this->contents;
    return serialize($this->contents);
  }

  public function setOrder() {

    if( isset($this->content['order']) && !is_null($this->content['order']) && is_numeric($this->content['order']) )
      return $this->content['order'];

    return $this->getNextOrder();

  }

  public function getNextOrder() {
    return collect($this->contents)->max('order') + 1;
  }

  public function updateContents($key=null) 
  {
    if(is_null($key)){
      $this->contents[] = $this->content;
    } else {
      $this->contents[$key] = $this->content;
    }

  }

  public function destroyContent($key=null)
  {
    if(is_null($key))
      return;
    if(!isset($this->contents[$key]))
      return;
    //remove the section
    unset($this->contents[$key]);
    //reset the array values
    $this->contents = array_values($this->contents);
    return;
  }


}
