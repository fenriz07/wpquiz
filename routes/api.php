<?php

use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\LevelsController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ProgramController;


/**
 *
 */
class apiRestTest
{

  private $action = 'process_question';


  function __construct()
  {
    $this->namespace = 'levelplacement/v1';

    add_action( 'rest_api_init', function () {

    	register_rest_route( $this->namespace, '/tests/category/(?P<id>\d+)',[
        'methods' => 'GET',
        'callback' => [TestController::class,'show'],
      ]);

      register_rest_route( $this->namespace, '/test/lvls/(?P<id>\d+)',[
        'methods' => 'GET',
        'callback' => [ LevelsController::class, 'show'],
      ]);

      register_rest_route( $this->namespace,  '/test/',[
        'methods'  => 'POST',
        'callback' => [TestController::class,'store'],
      ]);

      register_rest_route( $this->namespace,  '/contact/',[
        'methods'  => 'POST',
        'callback' => [ContactController::class,'store'],
      ]);

      
      register_rest_route( $this->namespace,  '/checkemailuc/',[
        'methods'  => 'POST',
        'callback' => [ProgramController::class,'show'],
      ]);
      

    });


  }

}


new apiRestTest();
