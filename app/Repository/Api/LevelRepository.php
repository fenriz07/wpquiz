<?php namespace App\Repository\Api;

use App\Models\TestModel;

class LevelRepository{

    public static function show( $idCategory, $shuffle = true )
    {

        $tests = TestModel::select()
        ->setCategory( $idCategory )
        ->base()
        //->addMeta(1)
        //->addAnswer()
        ->get();

        if ( empty( $tests ) ) {
            return new WP_Error( 'awesome_is_empty', 'No questions associated with the category', array( 'status' => 404 ) );
        }

        foreach ($tests as $key => $test)
        {

            $question_id = $test['id'];

            $type = testModel::typeQuestion( $question_id );

            $questions = testModel::getQuestionType($type,$question_id,$shuffle);
            
            $tests[$key]['lvl'] = $questions;
        }

        return ['levels' => $tests];
    }
}