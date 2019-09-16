<?php namespace App\Http\Controllers\Api;

use \WP_Error;
use App\Models\TestModel;
use App\Http\Requests\TestRequest;
use App\Repository\Api\TestRepository;

class TestController
{
    /**
     * Show function return TESTS
     */
    public static function show( $data )    
    {
        $question_id = $data['id'];

        $type = testModel::typeQuestion( $question_id );

        $questions = testModel::getQuestionType($type,$question_id);

        /*return $questions;


        $tests = TestModel::select()
            ->setCategory( $data['id'] )
            ->base()
            ->addMeta(1)
            //->addAnswer()
            ->get();

        if ( empty( $tests ) ) {
            return new WP_Error( 'awesome_is_empty', 'No questions associated with the category', array( 'status' => 404 ) );
        }*/

        return ['result' => $questions];
    }

    public static function store ( $request )
    {

        $r =  json_decode( $request->get_body(), true );

        $request = ( new TestRequest( $r ) )->getRequest();


        if( is_wp_error( $request ) )
        {
            return $request;      
        }
      
  
      $data = [
        'personal' => [
          'email'    => $request->email,
          /*'lastname' => $request->lastname,          
          'phone'    => $request->phone,*/
        ],
        'id_category' => $request->idtest,
        'action'      => $request->action,
        'test'        => $request->test,
        'name-test'   => $request->{'name-test'},
      ];

      ( new TestRepository() )->store( $data );

        
      $messages['status'] = 1;
      return $messages;
    
    }
}
