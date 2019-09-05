<?php namespace App\Http\Controllers\Api;

class LevelsController
{
    public static function show($data)
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