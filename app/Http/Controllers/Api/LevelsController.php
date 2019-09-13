<?php namespace App\Http\Controllers\Api;


use App\Models\TestModel;


class LevelsController
{
    public static function show($data)
    {

        $tests = TestModel::select()
        ->setCategory( $data['id'] )
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

            $questions = testModel::getQuestionType($type,$question_id);
            
            $tests[$key]['lvl'] = $questions;
        }

        return ['levels' => $tests];

       /* $nametaxonomy = 'category-test';
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

        return  ['levels' => $lvls ] ;   */         
        
    }
}