<?php


/**
 *
 */
class apiRestTest
{


  function __construct()
  {
    $this->namespace = 'levelplacement';

    add_action( 'rest_api_init', function () {
    	register_rest_route( $this->namespace .'/v1', '/tests/category/(?P<id>\d+)', array(
    		'methods' => 'GET',
    		'callback' => array( $this, 'getTests' ),
    	));
    });

  }

  public function getTests($data)
  {
    $tests = TestModel::select()
                          ->setCategory($data['id'])
                          ->base()
                          ->addMeta(1)
                          // ->addAnswer()
                          ->get();

    if ( empty( $tests ) ) {
  		return new WP_Error( 'awesome_is_empty', 'No questions associated with the category', array( 'status' => 404 ) );
  	}

    return $tests;
  }
}


new apiRestTest();
