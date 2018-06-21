<?php


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
        'callback' => [$this, 'getTests'],
      ]);
    });

    add_action( 'rest_api_init', function () {
      register_rest_route( $this->namespace, '/test/lvls/(?P<id>\d+)',[
        'methods' => 'GET',
        'callback' => [$this, 'getLvls'],
      ]);
    });


    add_action( 'rest_api_init', function(){
      register_rest_route( $this->namespace,  '/test/',[
        'methods'  => 'POST',
        'callback' => [$this,'setTest'],
      ]);
    });

    add_action( 'rest_api_init', function(){
      register_rest_route( $this->namespace,  '/contact/',[
        'methods'  => 'POST',
        'callback' => [$this,'setEmailContact'],
      ]);
    });

  }

  public function setEmailContact($request)
  {
    if(!isset($request['action'])){
      return new WP_Error( 'ups', 'Sorry no process', array( 'status' => 404 ) );
    }else {
      if($this->action != $request['action'] ){
        return new WP_Error( 'ups', 'Sorry no process', array( 'status' => 404 ) );
      }
    }

    $messages = [];

    if(!isset($request['lastname'])){
      $messages[] = new WP_Error( 'Validation Error', 'Missing the full name', array( 'status' => 7001 ) );
    }else {
      $request['lastname'] = filter_var($request['lastname'], FILTER_SANITIZE_STRING);
    }

    if(!isset($request['email'])){
        $messages[] = new WP_Error( 'Validation Error', 'Missing the email', array( 'status' => 7002 ) );
    }else {
        $request['email'] = filter_var($request['email'], FILTER_VALIDATE_EMAIL);
        if ($request['email']  == false) {
            $messages[] = new WP_Error( 'Validation Error', 'Email no validate', array( 'status' => 7002 ) );
        }
    }

    if(!isset($request['phone'])){
        $messages[] = new WP_Error( 'Validation Error', 'Missing Phone', array( 'status' => 7003 ) );
    }

    $data = [
      'personal' => [
        'lastname'  => $request['lastname'],
        'email'     => $request['email'],
        'phone'     => $request['phone'],
        'name-test' => $request['name-test']
      ]
    ];

    if(count($messages) > 0){
      $messages['status'] = 7000;
      return $messages;
    }else {
      //return $data;
      $pq = new ProcessContact();
      $pq->processingPost($data);

      $messages['status'] = 1;
      return $messages;
    }

  }

  public function getTests($data)
  {
    $tests = TestModel::select()
                          ->setCategory($data['id'])
                          ->base()
                          ->addMeta(1)
                          //->addAnswer()
                          ->get();

    if ( empty( $tests ) ) {
  		return new WP_Error( 'awesome_is_empty', 'No questions associated with the category', array( 'status' => 404 ) );
  	}

    return ['result' => $tests ];
  }

  public function setTest($request)
  {

    /*
    TODO: Validate action [x]
    TODO: Validate nonce
    TODO: Validation data type... prevent hack... go servio :) fkwp [x]
    */

    //De primerito validar con nonce...

    if(!isset($request['action'])){
      return new WP_Error( 'ups', 'Sorry no process', array( 'status' => 404 ) );
    }else {
      if($this->action != $request['action'] ){
        return new WP_Error( 'ups', 'Sorry no process', array( 'status' => 404 ) );
      }
    }

    $messages = [];

    if(!isset($request['lastname'])){
      $messages[] = new WP_Error( 'Validation Error', 'Missing the full name', array( 'status' => 7001 ) );
    }else {
      $request['lastname'] = filter_var($request['lastname'], FILTER_SANITIZE_STRING);
    }

    if(!isset($request['email'])){
        $messages[] = new WP_Error( 'Validation Error', 'Missing the email', array( 'status' => 7002 ) );
    }else {
        $request['email'] = filter_var($request['email'], FILTER_VALIDATE_EMAIL);
        if ($request['email']  == false) {
            $messages[] = new WP_Error( 'Validation Error', 'Email no validate', array( 'status' => 7002 ) );
        }
    }

    if(!isset($request['phone'])){
        $messages[] = new WP_Error( 'Validation Error', 'Missing Phone', array( 'status' => 7003 ) );
    }

    if(!isset($request['name-test'])){
      $messages[] = new WP_Error( 'Validation Error', 'Missing the name test', array( 'status' => 7004 ) );
    }else {
      $request['name-test'] = filter_var($request['name-test'], FILTER_SANITIZE_STRING);
    }

    if(!isset($request['id_category'])){
      $messages[] = new WP_Error( 'Validation Error', 'Missing category id', array( 'status' => 7005 ) );
    }else {
      $request['id_category'] = filter_var($request['id_category'], FILTER_VALIDATE_INT);
      if($request['id_category'] == false){
        $messages[] = new WP_Error( 'Validation Error', 'Category no is int', array( 'status' => 7005 ) );
      }
    }

    //return $request['test'];


    $data = [
      'personal' => [
        'lastname' => $request['lastname'],
        'email'    => $request['email'],
        'phone'    => $request['phone'],
      ],
      'id_category' => $request['id_category'],
      'action'      => $request['action'],
      'test'        => $request['test'],
      'name-test'   => $request['name-test'],
      'name-level'  => $request['name-level']
    ];

    //return $request['test'][1]['value'];



    if(count($messages) > 0){
      $messages['status'] = 7000;
      return $messages;
    }else {
      //return $data;
      $pq = new ProcessQuestion();
      $pq->processingPost($data);

      $messages['status'] = 1;
      return $messages;
    }

  }

  public function getLvls($data)
  {

    $nametaxonomy = 'category-test';
    $idcat        = $data['id'];
    $childrens    = get_term_children( $idcat, $nametaxonomy );
    $lvls         = [];

    foreach ($childrens as $key => $idchild) {
      $lvl    = get_term($idchild,$nametaxonomy);
      $lvls[] = [
          'idcat'   => $idchild,
          'namelvl' => $lvl->name
        ];
    }

    return  ['levels' => $lvls ] ;

  }

}


new apiRestTest();
