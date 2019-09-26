<?php namespace App\Http\Controllers\Api;

use App\Http\Requests\ContactRequest;
use App\Http\Controllers\BaseController;

/**
 *
 */

class ProgramController extends BaseController
{

  function __construct(){}

  public static function show($request)
  {

    return ['status' =>  404];
    
  }

  public static function store($request)
  {
    // Llamamos al evento asincrono, retornmos siempre el 200

    return ['status' => 200];
  }

}
