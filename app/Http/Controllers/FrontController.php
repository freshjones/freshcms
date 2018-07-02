<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Variables;

class FrontController extends Controller
{
  protected $settings;
  
  public function __construct(){

    $variables = DB::table('variables')->get();

    foreach($variables AS $variable)
    {
      $this->settings[$variable->name] = $variable->value;
    }

  }
 
}
