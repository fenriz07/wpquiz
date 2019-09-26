<?php

define('PREFIX_META_BOX_CATEGORYTEST' , 'categorytest-taxonomy-');

function prefix_register_taxonomy_meta_boxes_category_test( $meta_boxes )
{
    $meta_boxes[] = array(
        'index'      => '',
        'title'      => '',
        'taxonomies' => 'category-test',
        'fields' => array(
            [
                'name'       => 'Reglas de evaluación',
                'id'         =>  PREFIX_META_BOX_CATEGORYTEST . 'range-evaluations-testa',
                'type'       => 'group',
                'clone'      => true,
                'class'      => 'range-evaluation-test-taxonomy',
                'add_button' => 'Nueva regla',
                'fields' => [
                    [
                        'id'   => PREFIX_META_BOX_CATEGORYTEST . 'point',
                        'name' => '(Hasta) Ingrese un número',
                        'type' => 'text',
                        'attributes' => [
                            'type' => 'number',
                            'required' => true,
                            'class' => 'all-width',
                        ],
                    ],
                    [
                        'id'   => PREFIX_META_BOX_CATEGORYTEST . 'description',
                        'name' => 'Texto a mostrar',
                        'type' => 'wysiwyg',
                    ],
                    [
                        'id'          =>  PREFIX_META_BOX_CATEGORYTEST . 'courses-relations',
                        'name'        =>  'Cursos o Curso relacionados',
                        'multiple'    =>  true,         
                        'type'        => 'post',        
                        'post_type'   => 'lp_course',        
                        'field_type'  => 'select_advanced', 
                        'placeholder' => 'Vincule uno o mas cursos.',
                        'query_args'  => [
                            'post_status'    => 'publish',
                            'posts_per_page' => - 1,
                        ],
                        'attributes' => [
                            'class' => 'all-width',
                        ],
                    ]
                ],
            ],
            [
                'name'    => 'Instrucciones',
                'id'      =>  PREFIX_META_BOX_CATEGORYTEST . 'instruction',
                'type'    => 'wysiwyg',
            ]
        ),
    );
    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'prefix_register_taxonomy_meta_boxes_category_test' );


